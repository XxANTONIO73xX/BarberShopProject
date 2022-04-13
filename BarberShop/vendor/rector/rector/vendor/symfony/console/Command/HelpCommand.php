<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20211231\Symfony\Component\Console\Command;

use RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionInput;
use RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionSuggestions;
use RectorPrefix20211231\Symfony\Component\Console\Descriptor\ApplicationDescription;
use RectorPrefix20211231\Symfony\Component\Console\Helper\DescriptorHelper;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20211231\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20211231\Symfony\Component\Console\Output\OutputInterface;
/**
 * HelpCommand displays the help for a given command.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HelpCommand extends \RectorPrefix20211231\Symfony\Component\Console\Command\Command
{
    private $command;
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();
        $this->setName('help')->setDefinition([new \RectorPrefix20211231\Symfony\Component\Console\Input\InputArgument('command_name', \RectorPrefix20211231\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'The command name', 'help'), new \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption('format', null, \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The output format (txt, xml, json, or md)', 'txt'), new \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption('raw', null, \RectorPrefix20211231\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'To output raw command help')])->setDescription('Display help for a command')->setHelp(<<<'EOF'
The <info>%command.name%</info> command displays help for a given command:

  <info>%command.full_name% list</info>

You can also output the help in other formats by using the <comment>--format</comment> option:

  <info>%command.full_name% --format=xml list</info>

To display the list of available commands, please use the <info>list</info> command.
EOF
);
    }
    public function setCommand(\RectorPrefix20211231\Symfony\Component\Console\Command\Command $command)
    {
        $this->command = $command;
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(\RectorPrefix20211231\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20211231\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->command = $this->command ?? $this->getApplication()->find($input->getArgument('command_name'));
        $helper = new \RectorPrefix20211231\Symfony\Component\Console\Helper\DescriptorHelper();
        $helper->describe($output, $this->command, ['format' => $input->getOption('format'), 'raw_text' => $input->getOption('raw')]);
        unset($this->command);
        return 0;
    }
    public function complete(\RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionInput $input, \RectorPrefix20211231\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions) : void
    {
        if ($input->mustSuggestArgumentValuesFor('command_name')) {
            $descriptor = new \RectorPrefix20211231\Symfony\Component\Console\Descriptor\ApplicationDescription($this->getApplication());
            $suggestions->suggestValues(\array_keys($descriptor->getCommands()));
            return;
        }
        if ($input->mustSuggestOptionValuesFor('format')) {
            $helper = new \RectorPrefix20211231\Symfony\Component\Console\Helper\DescriptorHelper();
            $suggestions->suggestValues($helper->getFormats());
        }
    }
}
