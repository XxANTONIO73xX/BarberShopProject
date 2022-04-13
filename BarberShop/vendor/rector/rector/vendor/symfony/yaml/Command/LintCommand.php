<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20211231\Symfony\Component\Yaml\Command;

use RectorPrefix20211231\Symfony\Component\Console\CI\GithubActionReporter;
use RectorPrefix20211231\Symfony\Component\Console\Command\Command;
use RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionInput;
use RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionSuggestions;
use RectorPrefix20211231\Symfony\Component\Console\Exception\InvalidArgumentException;
use RectorPrefix20211231\Symfony\Component\Console\Exception\RuntimeException;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20211231\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20211231\Symfony\Component\Yaml\Exception\ParseException;
use RectorPrefix20211231\Symfony\Component\Yaml\Parser;
use RectorPrefix20211231\Symfony\Component\Yaml\Yaml;
/**
 * Validates YAML files syntax and outputs encountered errors.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class LintCommand extends \RectorPrefix20211231\Symfony\Component\Console\Command\Command
{
    protected static $defaultName = 'lint:yaml';
    protected static $defaultDescription = 'Lint a YAML file and outputs encountered errors';
    private $parser;
    private $format;
    private $displayCorrectFiles;
    private $directoryIteratorProvider;
    private $isReadableProvider;
    public function __construct(string $name = null, callable $directoryIteratorProvider = null, callable $isReadableProvider = null)
    {
        parent::__construct($name);
        $this->directoryIteratorProvider = $directoryIteratorProvider;
        $this->isReadableProvider = $isReadableProvider;
    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription(self::$defaultDescription)->addArgument('filename', \RectorPrefix20211231\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'A file, a directory or "-" for reading from STDIN')->addOption('format', null, \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The output format')->addOption('exclude', null, \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED | \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY, 'Path(s) to exclude')->addOption('parse-tags', null, \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_NEGATABLE, 'Parse custom tags', null)->setHelp(<<<EOF
The <info>%command.name%</info> command lints a YAML file and outputs to STDOUT
the first encountered syntax error.

You can validates YAML contents passed from STDIN:

  <info>cat filename | php %command.full_name% -</info>

You can also validate the syntax of a file:

  <info>php %command.full_name% filename</info>

Or of a whole directory:

  <info>php %command.full_name% dirname</info>
  <info>php %command.full_name% dirname --format=json</info>

You can also exclude one or more specific files:

  <info>php %command.full_name% dirname --exclude="dirname/foo.yaml" --exclude="dirname/bar.yaml"</info>

EOF
);
    }
    protected function execute(\RectorPrefix20211231\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20211231\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $io = new \RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
        $filenames = (array) $input->getArgument('filename');
        $excludes = $input->getOption('exclude');
        $this->format = $input->getOption('format');
        $flags = $input->getOption('parse-tags');
        if ('github' === $this->format && !\class_exists(\RectorPrefix20211231\Symfony\Component\Console\CI\GithubActionReporter::class)) {
            throw new \InvalidArgumentException('The "github" format is only available since "symfony/console" >= 5.3.');
        }
        if (null === $this->format) {
            // Autodetect format according to CI environment
            $this->format = \class_exists(\RectorPrefix20211231\Symfony\Component\Console\CI\GithubActionReporter::class) && \RectorPrefix20211231\Symfony\Component\Console\CI\GithubActionReporter::isGithubActionEnvironment() ? 'github' : 'txt';
        }
        $flags = $flags ? \RectorPrefix20211231\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS : 0;
        $this->displayCorrectFiles = $output->isVerbose();
        if (['-'] === $filenames) {
            return $this->display($io, [$this->validate(\file_get_contents('php://stdin'), $flags)]);
        }
        if (!$filenames) {
            throw new \RectorPrefix20211231\Symfony\Component\Console\Exception\RuntimeException('Please provide a filename or pipe file content to STDIN.');
        }
        $filesInfo = [];
        foreach ($filenames as $filename) {
            if (!$this->isReadable($filename)) {
                throw new \RectorPrefix20211231\Symfony\Component\Console\Exception\RuntimeException(\sprintf('File or directory "%s" is not readable.', $filename));
            }
            foreach ($this->getFiles($filename) as $file) {
                if (!\in_array($file->getPathname(), $excludes, \true)) {
                    $filesInfo[] = $this->validate(\file_get_contents($file), $flags, $file);
                }
            }
        }
        return $this->display($io, $filesInfo);
    }
    private function validate(string $content, int $flags, string $file = null)
    {
        $prevErrorHandler = \set_error_handler(function ($level, $message, $file, $line) use(&$prevErrorHandler) {
            if (\E_USER_DEPRECATED === $level) {
                throw new \RectorPrefix20211231\Symfony\Component\Yaml\Exception\ParseException($message, $this->getParser()->getRealCurrentLineNb() + 1);
            }
            return $prevErrorHandler ? $prevErrorHandler($level, $message, $file, $line) : \false;
        });
        try {
            $this->getParser()->parse($content, \RectorPrefix20211231\Symfony\Component\Yaml\Yaml::PARSE_CONSTANT | $flags);
        } catch (\RectorPrefix20211231\Symfony\Component\Yaml\Exception\ParseException $e) {
            return ['file' => $file, 'line' => $e->getParsedLine(), 'valid' => \false, 'message' => $e->getMessage()];
        } finally {
            \restore_error_handler();
        }
        return ['file' => $file, 'valid' => \true];
    }
    private function display(\RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle $io, array $files) : int
    {
        switch ($this->format) {
            case 'txt':
                return $this->displayTxt($io, $files);
            case 'json':
                return $this->displayJson($io, $files);
            case 'github':
                return $this->displayTxt($io, $files, \true);
            default:
                throw new \RectorPrefix20211231\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('The format "%s" is not supported.', $this->format));
        }
    }
    private function displayTxt(\RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle $io, array $filesInfo, bool $errorAsGithubAnnotations = \false) : int
    {
        $countFiles = \count($filesInfo);
        $erroredFiles = 0;
        $suggestTagOption = \false;
        if ($errorAsGithubAnnotations) {
            $githubReporter = new \RectorPrefix20211231\Symfony\Component\Console\CI\GithubActionReporter($io);
        }
        foreach ($filesInfo as $info) {
            if ($info['valid'] && $this->displayCorrectFiles) {
                $io->comment('<info>OK</info>' . ($info['file'] ? \sprintf(' in %s', $info['file']) : ''));
            } elseif (!$info['valid']) {
                ++$erroredFiles;
                $io->text('<error> ERROR </error>' . ($info['file'] ? \sprintf(' in %s', $info['file']) : ''));
                $io->text(\sprintf('<error> >> %s</error>', $info['message']));
                if (\false !== \strpos($info['message'], 'PARSE_CUSTOM_TAGS')) {
                    $suggestTagOption = \true;
                }
                if ($errorAsGithubAnnotations) {
                    $githubReporter->error($info['message'], $info['file'] ?? 'php://stdin', $info['line']);
                }
            }
        }
        if (0 === $erroredFiles) {
            $io->success(\sprintf('All %d YAML files contain valid syntax.', $countFiles));
        } else {
            $io->warning(\sprintf('%d YAML files have valid syntax and %d contain errors.%s', $countFiles - $erroredFiles, $erroredFiles, $suggestTagOption ? ' Use the --parse-tags option if you want parse custom tags.' : ''));
        }
        return \min($erroredFiles, 1);
    }
    private function displayJson(\RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle $io, array $filesInfo) : int
    {
        $errors = 0;
        \array_walk($filesInfo, function (&$v) use(&$errors) {
            $v['file'] = (string) $v['file'];
            if (!$v['valid']) {
                ++$errors;
            }
            if (isset($v['message']) && \false !== \strpos($v['message'], 'PARSE_CUSTOM_TAGS')) {
                $v['message'] .= ' Use the --parse-tags option if you want parse custom tags.';
            }
        });
        $io->writeln(\json_encode($filesInfo, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES));
        return \min($errors, 1);
    }
    private function getFiles(string $fileOrDirectory) : iterable
    {
        if (\is_file($fileOrDirectory)) {
            (yield new \SplFileInfo($fileOrDirectory));
            return;
        }
        foreach ($this->getDirectoryIterator($fileOrDirectory) as $file) {
            if (!\in_array($file->getExtension(), ['yml', 'yaml'])) {
                continue;
            }
            (yield $file);
        }
    }
    private function getParser() : \RectorPrefix20211231\Symfony\Component\Yaml\Parser
    {
        if (!$this->parser) {
            $this->parser = new \RectorPrefix20211231\Symfony\Component\Yaml\Parser();
        }
        return $this->parser;
    }
    private function getDirectoryIterator(string $directory) : iterable
    {
        $default = function ($directory) {
            return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS), \RecursiveIteratorIterator::LEAVES_ONLY);
        };
        if (null !== $this->directoryIteratorProvider) {
            return ($this->directoryIteratorProvider)($directory, $default);
        }
        return $default($directory);
    }
    private function isReadable(string $fileOrDirectory) : bool
    {
        $default = function ($fileOrDirectory) {
            return \is_readable($fileOrDirectory);
        };
        if (null !== $this->isReadableProvider) {
            return ($this->isReadableProvider)($fileOrDirectory, $default);
        }
        return $default($fileOrDirectory);
    }
    public function complete(\RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionInput $input, \RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions) : void
    {
        if ($input->mustSuggestOptionValuesFor('format')) {
            $suggestions->suggestValues(['txt', 'json', 'github']);
        }
    }
}
