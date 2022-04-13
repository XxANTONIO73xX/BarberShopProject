<?php

declare (strict_types=1);
namespace Ssch\TYPO3Rector\Template;

use Symplify\SmartFileSystem\SmartFileInfo;
final class TemplateFinder
{
    /**
     * @var string
     */
    private $templateDirectory;
    public function __construct()
    {
        $this->templateDirectory = __DIR__ . '/../../templates/maker/';
    }
    public function getCommand() : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->createSmartFileInfo('Commands/Command.tpl');
    }
    public function getCommandsConfiguration() : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->createSmartFileInfo('Commands/Commands.tpl');
    }
    public function getExtbasePersistenceConfiguration() : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->createSmartFileInfo('Extbase/Persistence.tpl');
    }
    private function createSmartFileInfo(string $template) : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \Symplify\SmartFileSystem\SmartFileInfo($this->templateDirectory . $template);
    }
}
