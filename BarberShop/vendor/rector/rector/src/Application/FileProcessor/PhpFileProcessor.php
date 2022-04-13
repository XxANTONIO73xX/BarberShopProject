<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileProcessor;

use PHPStan\AnalysedCodeException;
use Rector\ChangesReporting\ValueObjectFactory\ErrorFactory;
use Rector\Core\Application\FileDecorator\FileDiffFileDecorator;
use Rector\Core\Application\FileProcessor;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\Enum\ApplicationPhase;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Printer\FormatPerservingPrinter;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Configuration;
use Rector\Core\ValueObject\Error\SystemError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use Rector\Parallel\ValueObject\Bridge;
use Rector\PostRector\Application\PostFileProcessor;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
final class PhpFileProcessor implements \Rector\Core\Contract\Processor\FileProcessorInterface
{
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Printer\FormatPerservingPrinter
     */
    private $formatPerservingPrinter;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileProcessor
     */
    private $fileProcessor;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @readonly
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileDecorator\FileDiffFileDecorator
     */
    private $fileDiffFileDecorator;
    /**
     * @readonly
     * @var \Rector\Core\Provider\CurrentFileProvider
     */
    private $currentFileProvider;
    /**
     * @readonly
     * @var \Rector\PostRector\Application\PostFileProcessor
     */
    private $postFileProcessor;
    /**
     * @readonly
     * @var \Rector\ChangesReporting\ValueObjectFactory\ErrorFactory
     */
    private $errorFactory;
    public function __construct(\Rector\Core\PhpParser\Printer\FormatPerservingPrinter $formatPerservingPrinter, \Rector\Core\Application\FileProcessor $fileProcessor, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\Application\FileDecorator\FileDiffFileDecorator $fileDiffFileDecorator, \Rector\Core\Provider\CurrentFileProvider $currentFileProvider, \Rector\PostRector\Application\PostFileProcessor $postFileProcessor, \Rector\ChangesReporting\ValueObjectFactory\ErrorFactory $errorFactory)
    {
        $this->formatPerservingPrinter = $formatPerservingPrinter;
        $this->fileProcessor = $fileProcessor;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->symfonyStyle = $symfonyStyle;
        $this->fileDiffFileDecorator = $fileDiffFileDecorator;
        $this->currentFileProvider = $currentFileProvider;
        $this->postFileProcessor = $postFileProcessor;
        $this->errorFactory = $errorFactory;
    }
    /**
     * @return array{system_errors: SystemError[], file_diffs: FileDiff[]}
     */
    public function process(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : array
    {
        $systemErrorsAndFileDiffs = [\Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS => [], \Rector\Parallel\ValueObject\Bridge::FILE_DIFFS => []];
        // 1. parse files to nodes
        $parsingSystemErrors = $this->parseFileAndDecorateNodes($file);
        if ($parsingSystemErrors !== []) {
            // we cannot process this file as the parsing and type resolving itself went wrong
            $systemErrorsAndFileDiffs[\Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS] = $parsingSystemErrors;
            $this->notifyPhase($file, \Rector\Core\Enum\ApplicationPhase::PRINT_SKIP());
            return $systemErrorsAndFileDiffs;
        }
        // 2. change nodes with Rectors
        $loopCounter = 0;
        do {
            ++$loopCounter;
            if ($loopCounter === 10) {
                // ensure no infinite loop
                break;
            }
            $file->changeHasChanged(\false);
            $this->refactorNodesWithRectors($file, $configuration);
            // 3. apply post rectors
            $this->notifyPhase($file, \Rector\Core\Enum\ApplicationPhase::POST_RECTORS());
            $newStmts = $this->postFileProcessor->traverse($file->getNewStmts());
            // this is needed for new tokens added in "afterTraverse()"
            $file->changeNewStmts($newStmts);
            // 4. print to file or string
            $this->currentFileProvider->setFile($file);
            // important to detect if file has changed
            $this->notifyPhase($file, \Rector\Core\Enum\ApplicationPhase::PRINT());
            $this->printFile($file, $configuration);
        } while ($file->hasChanged());
        // return json here
        $fileDiff = $file->getFileDiff();
        if (!$fileDiff instanceof \Rector\Core\ValueObject\Reporting\FileDiff) {
            return $systemErrorsAndFileDiffs;
        }
        $systemErrorsAndFileDiffs[\Rector\Parallel\ValueObject\Bridge::FILE_DIFFS] = [$fileDiff];
        return $systemErrorsAndFileDiffs;
    }
    public function supports(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : bool
    {
        $smartFileInfo = $file->getSmartFileInfo();
        return $smartFileInfo->hasSuffixes($configuration->getFileExtensions());
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return ['php'];
    }
    private function refactorNodesWithRectors(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : void
    {
        $this->currentFileProvider->setFile($file);
        $this->notifyPhase($file, \Rector\Core\Enum\ApplicationPhase::REFACTORING());
        $this->fileProcessor->refactor($file, $configuration);
    }
    /**
     * @return SystemError[]
     */
    private function parseFileAndDecorateNodes(\Rector\Core\ValueObject\Application\File $file) : array
    {
        $this->currentFileProvider->setFile($file);
        $this->notifyPhase($file, \Rector\Core\Enum\ApplicationPhase::PARSING());
        try {
            $this->fileProcessor->parseFileInfoToLocalCache($file);
        } catch (\Rector\Core\Exception\ShouldNotHappenException $shouldNotHappenException) {
            throw $shouldNotHappenException;
        } catch (\PHPStan\AnalysedCodeException $analysedCodeException) {
            // inform about missing classes in tests
            if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
                throw $analysedCodeException;
            }
            $autoloadSystemError = $this->errorFactory->createAutoloadError($analysedCodeException, $file->getSmartFileInfo());
            return [$autoloadSystemError];
        } catch (\Throwable $throwable) {
            if ($this->symfonyStyle->isVerbose() || \Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
                throw $throwable;
            }
            $systemError = new \Rector\Core\ValueObject\Error\SystemError($throwable->getMessage(), $file->getRelativeFilePath(), $throwable->getLine());
            return [$systemError];
        }
        return [];
    }
    private function printFile(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : void
    {
        $smartFileInfo = $file->getSmartFileInfo();
        if ($this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo)) {
            // skip, because this file exists no more
            return;
        }
        $newContent = $configuration->isDryRun() ? $this->formatPerservingPrinter->printParsedStmstAndTokensToString($file) : $this->formatPerservingPrinter->printParsedStmstAndTokens($file);
        $file->changeFileContent($newContent);
        $this->fileDiffFileDecorator->decorate([$file]);
    }
    private function notifyPhase(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\Enum\ApplicationPhase $applicationPhase) : void
    {
        if (!$this->symfonyStyle->isVerbose()) {
            return;
        }
        $smartFileInfo = $file->getSmartFileInfo();
        $relativeFilePath = $smartFileInfo->getRelativeFilePathFromDirectory(\getcwd());
        $message = \sprintf('[%s] %s', $applicationPhase, $relativeFilePath);
        $this->symfonyStyle->writeln($message);
    }
}
