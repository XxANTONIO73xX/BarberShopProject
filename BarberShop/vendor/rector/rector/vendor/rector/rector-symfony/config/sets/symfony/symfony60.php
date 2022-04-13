<?php

declare (strict_types=1);
namespace RectorPrefix20211231;

use PhpParser\Node\Scalar\String_;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony\Rector\FuncCall\ReplaceServiceArgumentRector;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\ValueObject\ReplaceServiceArgument;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# https://github.com/symfony/symfony/blob/6.1/UPGRADE-6.0.md
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES);
    $containerConfigurator->import(__DIR__ . '/symfony6/symfony-return-types.php');
    // @see https://github.com/symfony/symfony/pull/35879
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\FuncCall\ReplaceServiceArgumentRector::class)->configure([new \Rector\Symfony\ValueObject\ReplaceServiceArgument('Psr\\Container\\ContainerInterface', new \PhpParser\Node\Scalar\String_('service_container')), new \Rector\Symfony\ValueObject\ReplaceServiceArgument('Symfony\\Component\\DependencyInjection\\ContainerInterface', new \PhpParser\Node\Scalar\String_('service_container'))]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->configure([
        // @see https://github.com/symfony/symfony/pull/39484
        'Symfony\\Contracts\\HttpClient\\HttpClientInterface\\RemoteJsonManifestVersionStrategy' => 'Symfony\\Component\\Asset\\VersionStrategy\\JsonManifestVersionStrategy',
    ]);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->configure([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Config\\Loader\\LoaderInterface', 'load', 0, new \PHPStan\Type\MixedType()), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Bundle\\FrameworkBundle\\Kernel\\MicroKernelTrait', 'configureRoutes', 0, new \PHPStan\Type\ObjectType('Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator'))]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->configure([
        // @see https://github.com/symfony/symfony/pull/40403
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Bridge\\Doctrine\\Security\\User\\UserLoaderInterface', 'loadUserByUsername', 'loadUserByIdentifier'),
    ]);
};
