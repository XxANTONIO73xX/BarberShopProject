<?php

declare (strict_types=1);
namespace RectorPrefix20211231;

use RectorPrefix20211231\Nette\Neon\Decoder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Nette\\NeonParser\\', __DIR__ . '/../packages/NeonParser')->exclude([__DIR__ . '/../packages/NeonParser/NeonNodeTraverser.php', __DIR__ . '/../packages/NeonParser/Node']);
    $services->set(\RectorPrefix20211231\Nette\Neon\Decoder::class);
};
