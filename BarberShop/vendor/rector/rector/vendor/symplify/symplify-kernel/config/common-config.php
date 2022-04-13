<?php

declare (strict_types=1);
namespace RectorPrefix20211231;

use RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20211231\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20211231\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20211231\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20211231\Symplify\SmartFileSystem\FileSystemFilter;
use RectorPrefix20211231\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20211231\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20211231\Symplify\SmartFileSystem\Finder\SmartFinder;
use RectorPrefix20211231\Symplify\SmartFileSystem\SmartFileSystem;
use function RectorPrefix20211231\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\RectorPrefix20211231\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20211231\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20211231\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20211231\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\RectorPrefix20211231\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\RectorPrefix20211231\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\RectorPrefix20211231\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\RectorPrefix20211231\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\RectorPrefix20211231\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\RectorPrefix20211231\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\RectorPrefix20211231\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\RectorPrefix20211231\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
