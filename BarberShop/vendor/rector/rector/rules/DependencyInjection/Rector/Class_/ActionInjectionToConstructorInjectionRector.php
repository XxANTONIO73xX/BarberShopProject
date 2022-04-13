<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\DependencyInjection\Collector\VariablesToPropertyFetchCollection;
use Rector\PostRector\Collector\PropertyToAddCollector;
use Rector\PostRector\ValueObject\PropertyMetadata;
use Rector\Symfony\DataProvider\ServiceMapProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DependencyInjection\Rector\Class_\ActionInjectionToConstructorInjectionRector\ActionInjectionToConstructorInjectionRectorTest
 */
final class ActionInjectionToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @readonly
     * @var \Rector\Symfony\DataProvider\ServiceMapProvider
     */
    private $applicationServiceMapProvider;
    /**
     * @readonly
     * @var \Rector\DependencyInjection\Collector\VariablesToPropertyFetchCollection
     */
    private $variablesToPropertyFetchCollection;
    /**
     * @readonly
     * @var \Rector\PostRector\Collector\PropertyToAddCollector
     */
    private $propertyToAddCollector;
    public function __construct(\Rector\Symfony\DataProvider\ServiceMapProvider $applicationServiceMapProvider, \Rector\DependencyInjection\Collector\VariablesToPropertyFetchCollection $variablesToPropertyFetchCollection, \Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector)
    {
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
        $this->variablesToPropertyFetchCollection = $variablesToPropertyFetchCollection;
        $this->propertyToAddCollector = $propertyToAddCollector;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns action injection in Controllers to constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function default(ProductRepository $productRepository)
    {
        $products = $productRepository->fetchAll();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function default()
    {
        $products = $this->productRepository->fetchAll();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, '*Controller')) {
            return null;
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->refactorVariablesToPropertyFetches($classMethod);
        }
        return $node;
    }
    private function refactorVariablesToPropertyFetches(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!$classMethod->isPublic()) {
            return;
        }
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            foreach ($this->variablesToPropertyFetchCollection->getVariableNamesAndTypes() as $name => $objectType) {
                if (!$this->isName($node, $name)) {
                    continue;
                }
                if (!$this->isObjectType($node, $objectType)) {
                    continue;
                }
                return $this->nodeFactory->createPropertyFetch('this', $name);
            }
            return null;
        });
    }
    private function processClassMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        foreach ($classMethod->params as $key => $paramNode) {
            if (!$this->isActionInjectedParamNode($paramNode)) {
                continue;
            }
            $paramType = $this->getType($paramNode);
            if (!$paramType instanceof \PHPStan\Type\ObjectType) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            /** @var string $paramName */
            $paramName = $this->getName($paramNode->var);
            $propertyMetadata = new \Rector\PostRector\ValueObject\PropertyMetadata($paramName, $paramType, \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
            $this->propertyToAddCollector->addPropertyToClass($class, $propertyMetadata);
            $this->nodeRemover->removeParam($classMethod, $key);
            $this->variablesToPropertyFetchCollection->addVariableNameAndType($paramName, $paramType);
        }
    }
    private function isActionInjectedParamNode(\PhpParser\Node\Param $param) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        $typehint = $this->getName($param->type);
        if ($typehint === null) {
            return \false;
        }
        $paramStaticType = $this->getType($param);
        if (!$paramStaticType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        $serviceMap = $this->applicationServiceMapProvider->provide();
        return $serviceMap->hasService($paramStaticType->getClassName());
    }
}
