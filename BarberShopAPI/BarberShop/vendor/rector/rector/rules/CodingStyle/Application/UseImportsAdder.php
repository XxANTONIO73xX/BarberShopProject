<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Application;

use RectorPrefix20211231\Nette\Utils\Strings;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Use_;
use PHPStan\Type\ObjectType;
use Rector\CodingStyle\ClassNameImport\UsedImportsResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class UseImportsAdder
{
    /**
     * @readonly
     * @var \Rector\CodingStyle\ClassNameImport\UsedImportsResolver
     */
    private $usedImportsResolver;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory
     */
    private $typeFactory;
    public function __construct(\Rector\CodingStyle\ClassNameImport\UsedImportsResolver $usedImportsResolver, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->usedImportsResolver = $usedImportsResolver;
        $this->typeFactory = $typeFactory;
    }
    /**
     * @param Stmt[] $stmts
     * @param array<FullyQualifiedObjectType|AliasedObjectType> $useImportTypes
     * @param array<FullyQualifiedObjectType|AliasedObjectType> $functionUseImportTypes
     * @return Stmt[]
     */
    public function addImportsToStmts(array $stmts, array $useImportTypes, array $functionUseImportTypes) : array
    {
        $existingUseImportTypes = $this->usedImportsResolver->resolveForStmts($stmts);
        $existingFunctionUseImports = $this->usedImportsResolver->resolveFunctionImportsForStmts($stmts);
        $useImportTypes = $this->diffFullyQualifiedObjectTypes($useImportTypes, $existingUseImportTypes);
        $functionUseImportTypes = $this->diffFullyQualifiedObjectTypes($functionUseImportTypes, $existingFunctionUseImports);
        $newUses = $this->createUses($useImportTypes, $functionUseImportTypes, null);
        if ($newUses === []) {
            return $stmts;
        }
        // place after declare strict_types
        foreach ($stmts as $key => $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\Declare_) {
                if (isset($stmts[$key + 1]) && $stmts[$key + 1] instanceof \PhpParser\Node\Stmt\Use_) {
                    $nodesToAdd = $newUses;
                } else {
                    // add extra space, if there are no new use imports to be added
                    $nodesToAdd = \array_merge([new \PhpParser\Node\Stmt\Nop()], $newUses);
                }
                \array_splice($stmts, $key + 1, 0, $nodesToAdd);
                return $stmts;
            }
        }
        // make use stmts first
        return \array_merge($newUses, $stmts);
    }
    /**
     * @param FullyQualifiedObjectType[] $useImportTypes
     * @param FullyQualifiedObjectType[] $functionUseImportTypes
     */
    public function addImportsToNamespace(\PhpParser\Node\Stmt\Namespace_ $namespace, array $useImportTypes, array $functionUseImportTypes) : void
    {
        $namespaceName = $this->getNamespaceName($namespace);
        $existingUseImportTypes = $this->usedImportsResolver->resolveForNode($namespace);
        $existingFunctionUseImportTypes = $this->usedImportsResolver->resolveFunctionImportsForStmts($namespace->stmts);
        $existingUseImportTypes = $this->typeFactory->uniquateTypes($existingUseImportTypes);
        $useImportTypes = $this->diffFullyQualifiedObjectTypes($useImportTypes, $existingUseImportTypes);
        $functionUseImportTypes = $this->diffFullyQualifiedObjectTypes($functionUseImportTypes, $existingFunctionUseImportTypes);
        $newUses = $this->createUses($useImportTypes, $functionUseImportTypes, $namespaceName);
        if ($namespace->stmts[0] instanceof \PhpParser\Node\Stmt\Use_ && $newUses !== []) {
            $comments = (array) $namespace->stmts[0]->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS);
            if ($comments !== []) {
                $newUses[0]->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $namespace->stmts[0]->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS));
                $namespace->stmts[0]->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
            }
        }
        $namespace->stmts = \array_merge($newUses, $namespace->stmts);
    }
    /**
     * @param array<FullyQualifiedObjectType|AliasedObjectType> $mainTypes
     * @param array<FullyQualifiedObjectType|AliasedObjectType> $typesToRemove
     * @return array<FullyQualifiedObjectType|AliasedObjectType>
     */
    private function diffFullyQualifiedObjectTypes(array $mainTypes, array $typesToRemove) : array
    {
        foreach ($mainTypes as $key => $mainType) {
            foreach ($typesToRemove as $typeToRemove) {
                if ($mainType->equals($typeToRemove)) {
                    unset($mainTypes[$key]);
                }
            }
        }
        return \array_values($mainTypes);
    }
    /**
     * @param array<AliasedObjectType|FullyQualifiedObjectType> $useImportTypes
     * @param array<FullyQualifiedObjectType|AliasedObjectType> $functionUseImportTypes
     * @return Use_[]
     */
    private function createUses(array $useImportTypes, array $functionUseImportTypes, ?string $namespaceName) : array
    {
        $newUses = [];
        foreach ($useImportTypes as $useImportType) {
            if ($namespaceName !== null && $this->isCurrentNamespace($namespaceName, $useImportType)) {
                continue;
            }
            // already imported in previous cycle
            $newUses[] = $useImportType->getUseNode();
        }
        foreach ($functionUseImportTypes as $functionUseImportType) {
            if ($namespaceName !== null && $this->isCurrentNamespace($namespaceName, $functionUseImportType)) {
                continue;
            }
            // already imported in previous cycle
            $newUses[] = $functionUseImportType->getFunctionUseNode();
        }
        return $newUses;
    }
    private function getNamespaceName(\PhpParser\Node\Stmt\Namespace_ $namespace) : ?string
    {
        if ($namespace->name === null) {
            return null;
        }
        return $namespace->name->toString();
    }
    private function isCurrentNamespace(string $namespaceName, \PHPStan\Type\ObjectType $objectType) : bool
    {
        $afterCurrentNamespace = \RectorPrefix20211231\Nette\Utils\Strings::after($objectType->getClassName(), $namespaceName . '\\');
        if ($afterCurrentNamespace === null) {
            return \false;
        }
        return \strpos($afterCurrentNamespace, '\\') === \false;
    }
}
