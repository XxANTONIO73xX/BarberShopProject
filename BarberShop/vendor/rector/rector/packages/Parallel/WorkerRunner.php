<?php

declare (strict_types=1);
namespace Rector\Parallel;

use RectorPrefix20211231\Clue\React\NDJson\Decoder;
use RectorPrefix20211231\Clue\React\NDJson\Encoder;
use Rector\Core\Application\FileProcessor\PhpFileProcessor;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Configuration;
use Rector\Core\ValueObject\Error\SystemError;
use Rector\Parallel\ValueObject\Bridge;
use RectorPrefix20211231\Symplify\EasyParallel\Enum\Action;
use RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactCommand;
use RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactEvent;
use RectorPrefix20211231\Symplify\PackageBuilder\Yaml\ParametersMerger;
use Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class WorkerRunner
{
    /**
     * @var string
     */
    private const RESULT = 'result';
    /**
     * @readonly
     * @var \Symplify\PackageBuilder\Yaml\ParametersMerger
     */
    private $parametersMerger;
    /**
     * @readonly
     * @var \Rector\Core\Provider\CurrentFileProvider
     */
    private $currentFileProvider;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileProcessor\PhpFileProcessor
     */
    private $phpFileProcessor;
    public function __construct(\RectorPrefix20211231\Symplify\PackageBuilder\Yaml\ParametersMerger $parametersMerger, \Rector\Core\Provider\CurrentFileProvider $currentFileProvider, \Rector\Core\Application\FileProcessor\PhpFileProcessor $phpFileProcessor)
    {
        $this->parametersMerger = $parametersMerger;
        $this->currentFileProvider = $currentFileProvider;
        $this->phpFileProcessor = $phpFileProcessor;
    }
    public function run(\RectorPrefix20211231\Clue\React\NDJson\Encoder $encoder, \RectorPrefix20211231\Clue\React\NDJson\Decoder $decoder, \Rector\Core\ValueObject\Configuration $configuration) : void
    {
        // 1. handle system error
        $handleErrorCallback = static function (\Throwable $throwable) use($encoder) : void {
            $systemErrors = new \Rector\Core\ValueObject\Error\SystemError($throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
            $encoder->write([\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactCommand::ACTION => \RectorPrefix20211231\Symplify\EasyParallel\Enum\Action::RESULT, self::RESULT => [\Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS => [$systemErrors], \Rector\Parallel\ValueObject\Bridge::FILES_COUNT => 0, \Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS_COUNT => 1]]);
            $encoder->end();
        };
        $encoder->on(\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactEvent::ERROR, $handleErrorCallback);
        // 2. collect diffs + errors from file processor
        $decoder->on(\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactEvent::DATA, function (array $json) use($encoder, $configuration) : void {
            $action = $json[\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactCommand::ACTION];
            if ($action !== \RectorPrefix20211231\Symplify\EasyParallel\Enum\Action::MAIN) {
                return;
            }
            $systemErrorsCount = 0;
            /** @var string[] $filePaths */
            $filePaths = $json[\Rector\Parallel\ValueObject\Bridge::FILES] ?? [];
            $errorAndFileDiffs = [];
            $systemErrors = [];
            foreach ($filePaths as $filePath) {
                try {
                    $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($filePath);
                    $file = new \Rector\Core\ValueObject\Application\File($smartFileInfo, $smartFileInfo->getContents());
                    $this->currentFileProvider->setFile($file);
                    $currentErrorsAndFileDiffs = $this->phpFileProcessor->process($file, $configuration);
                    $errorAndFileDiffs = $this->parametersMerger->merge($errorAndFileDiffs, $currentErrorsAndFileDiffs);
                } catch (\Throwable $throwable) {
                    ++$systemErrorsCount;
                    $errorMessage = \sprintf('System error: "%s"', $throwable->getMessage()) . \PHP_EOL;
                    $errorMessage .= 'Run Rector with "--debug" option and post the report here: https://github.com/rectorphp/rector/issues/new';
                    $systemErrors[] = new \Rector\Core\ValueObject\Error\SystemError($errorMessage, $filePath, $throwable->getLine());
                }
            }
            /**
             * this invokes all listeners listening $decoder->on(...) @see \Symplify\EasyParallel\Enum\ReactEvent::DATA
             */
            $encoder->write([\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactCommand::ACTION => \RectorPrefix20211231\Symplify\EasyParallel\Enum\Action::RESULT, self::RESULT => [\Rector\Parallel\ValueObject\Bridge::FILE_DIFFS => $errorAndFileDiffs[\Rector\Parallel\ValueObject\Bridge::FILE_DIFFS] ?? [], \Rector\Parallel\ValueObject\Bridge::FILES_COUNT => \count($filePaths), \Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS => $systemErrors, \Rector\Parallel\ValueObject\Bridge::SYSTEM_ERRORS_COUNT => $systemErrorsCount]]);
        });
        $decoder->on(\RectorPrefix20211231\Symplify\EasyParallel\Enum\ReactEvent::ERROR, $handleErrorCallback);
    }
}
