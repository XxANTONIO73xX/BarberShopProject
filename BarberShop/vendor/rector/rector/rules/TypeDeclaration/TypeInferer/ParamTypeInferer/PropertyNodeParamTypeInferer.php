<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use RectorPrefix20211231\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class PropertyNodeParamTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @readonly
     * @var \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @readonly
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @readonly
     * @var \Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory
     */
    private $typeFactory;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20211231\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeFactory = $typeFactory;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function inferParam(\PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $classLike = $this->betterNodeFinder->findParentType($param, \PhpParser\Node\Stmt\Class_::class);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return new \PHPStan\Type\MixedType();
        }
        $paramName = $this->nodeNameResolver->getName($param);
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $propertyStaticTypes = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use($paramName, &$propertyStaticTypes) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->propertyFetchAnalyzer->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }
            $propertyStaticTypes[] = $this->nodeTypeResolver->getType($node->var);
            return null;
        });
        return $this->typeFactory->createMixedPassedOrUnionType($propertyStaticTypes);
    }
}
