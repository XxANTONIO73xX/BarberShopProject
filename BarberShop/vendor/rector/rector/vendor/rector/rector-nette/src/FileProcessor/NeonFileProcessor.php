<?php

declare (strict_types=1);
namespace Rector\Nette\FileProcessor;

use Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Configuration;
use Rector\Core\ValueObject\Error\SystemError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use Rector\Nette\Contract\Rector\NeonRectorInterface;
use Rector\Nette\NeonParser\NeonNodeTraverserFactory;
use Rector\Nette\NeonParser\NeonParser;
use Rector\Nette\NeonParser\Printer\FormatPreservingNeonPrinter;
use Rector\Parallel\ValueObject\Bridge;
final class NeonFileProcessor implements \Rector\Core\Contract\Processor\FileProcessorInterface
{
    /**
     * @var \Rector\Nette\NeonParser\NeonParser
     */
    private $neonParser;
    /**
     * @var \Rector\Nette\NeonParser\NeonNodeTraverserFactory
     */
    private $neonNodeTraverserFactory;
    /**
     * @var \Rector\Nette\NeonParser\Printer\FormatPreservingNeonPrinter
     */
    private $formatPreservingNeonPrinter;
    /**
     * @var NeonRectorInterface[]
     */
    private $neonRectors;
    /**
     * @var \Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory
     */
    private $fileDiffFactory;
    /**
     * @param NeonRectorInterface[] $neonRectors
     */
    public function __construct(\Rector\Nette\NeonParser\NeonParser $neonParser, \Rector\Nette\NeonParser\NeonNodeTraverserFactory $neonNodeTraverserFactory, \Rector\Nette\NeonParser\Printer\FormatPreservingNeonPrinter $formatPreservingNeonPrinter, array $neonRectors, \Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory $fileDiffFactory)
    {
        $this->neonParser = $neonParser;
        $this->neonNodeTraverserFactory = $neonNodeTraverserFactory;
        $this->formatPreservingNeonPrinter = $formatPreservingNeonPrinter;
        $this->neonRectors = $neonRectors;
        $this->fileDiffFactory = $fileDiffFactory;
    }
    /**
     * @return array{system_errors: SystemError[], file_diffs: FileDiff[]}
     */
    public function process(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : array
    {
        $systemErrorsAndFileDiffs = [\Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS => [], \Rector\Parallel\ValueObject\Bridge::FILE_DIFFS => []];
        if ($this->neonRectors === []) {
            return $systemErrorsAndFileDiffs;
        }
        $fileContent = $file->getFileContent();
        $neonNode = $this->neonParser->parseString($fileContent);
        $neonNodeTraverser = $this->neonNodeTraverserFactory->create();
        foreach ($this->neonRectors as $neonRector) {
            $neonNodeTraverser->addNeonNodeVisitor($neonRector);
        }
        $originalPrintedContent = $this->formatPreservingNeonPrinter->printNode($neonNode, $fileContent);
        $neonNode = $neonNodeTraverser->traverse($neonNode);
        $changedFileContent = $this->formatPreservingNeonPrinter->printNode($neonNode, $fileContent);
        // has node changed?
        if ($changedFileContent === $originalPrintedContent) {
            return $systemErrorsAndFileDiffs;
        }
        $file->changeFileContent($changedFileContent);
        $fileDiff = $this->fileDiffFactory->createFileDiff($file, $originalPrintedContent, $changedFileContent);
        $systemErrorsAndFileDiffs[\Rector\Parallel\ValueObject\Bridge::FILE_DIFFS][] = $fileDiff;
        return $systemErrorsAndFileDiffs;
    }
    public function supports(\Rector\Core\ValueObject\Application\File $file, \Rector\Core\ValueObject\Configuration $configuration) : bool
    {
        $fileInfo = $file->getSmartFileInfo();
        return $fileInfo->hasSuffixes($this->getSupportedFileExtensions());
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return ['neon'];
    }
}
