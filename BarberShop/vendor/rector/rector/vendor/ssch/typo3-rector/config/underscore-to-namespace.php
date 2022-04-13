<?php

declare (strict_types=1);
namespace RectorPrefix20211231;

use Ssch\TYPO3Rector\Rector\Migrations\RenameClassMapAliasRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Ssch\TYPO3Rector\Rector\Migrations\RenameClassMapAliasRector::class)->configure([__DIR__ . '/../Migrations/Code/ClassAliasMap.php']);
};
