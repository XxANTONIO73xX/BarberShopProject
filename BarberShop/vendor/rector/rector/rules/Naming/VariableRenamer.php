<?php

declare (strict_types=1);
namespace Rector\Naming;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Naming\PhpDoc\VarTagValueNodeRenamer;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20211231\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class VariableRenamer
{
    /**
     * @readonly
     * @var \Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @readonly
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @readonly
     * @var \Rector\Naming\PhpDoc\VarTagValueNodeRenamer
     */
    private $varTagValueNodeRenamer;
    /**
     * @readonly
     * @var \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\RectorPrefix20211231\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Naming\PhpDoc\VarTagValueNodeRenamer $varTagValueNodeRenamer, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->varTagValueNodeRenamer = $varTagValueNodeRenamer;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @param \PhpParser\Node\Expr\Closure|\PhpParser\Node\Stmt\ClassMethod|\PhpParser\Node\Stmt\Function_ $functionLike
     */
    public function renameVariableInFunctionLike($functionLike, string $oldName, string $expectedName, ?\PhpParser\Node\Expr\Assign $assign = null) : void
    {
        $isRenamingActive = \false;
        if ($assign === null) {
            $isRenamingActive = \true;
        }
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $functionLike->stmts, function (\PhpParser\Node $node) use($oldName, $expectedName, $assign, &$isRenamingActive) : ?Variable {
            if ($assign !== null && $node === $assign) {
                $isRenamingActive = \true;
                return null;
            }
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            // skip param names
            $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parent instanceof \PhpParser\Node\Param) {
                return null;
            }
            // TODO: Remove in next PR (with above param check?),
            // TODO: Should be implemented in BreakingVariableRenameGuard::shouldSkipParam()
            if ($this->isParamInParentFunction($node)) {
                return null;
            }
            if (!$isRenamingActive) {
                return null;
            }
            return $this->renameVariableIfMatchesName($node, $oldName, $expectedName);
        });
    }
    private function isParamInParentFunction(\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $closure = $this->betterNodeFinder->findParentType($variable, \PhpParser\Node\Expr\Closure::class);
        if (!$closure instanceof \PhpParser\Node\Expr\Closure) {
            return \false;
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        if ($variableName === null) {
            return \false;
        }
        foreach ($closure->params as $param) {
            if ($this->nodeNameResolver->isName($param, $variableName)) {
                return \true;
            }
        }
        return \false;
    }
    private function renameVariableIfMatchesName(\PhpParser\Node\Expr\Variable $variable, string $oldName, string $expectedName) : ?\PhpParser\Node\Expr\Variable
    {
        if (!$this->nodeNameResolver->isName($variable, $oldName)) {
            return null;
        }
        $variable->name = $expectedName;
        $variablePhpDocInfo = $this->resolvePhpDocInfo($variable);
        $this->varTagValueNodeRenamer->renameAssignVarTagVariableName($variablePhpDocInfo, $oldName, $expectedName);
        return $variable;
    }
    /**
     * Expression doc block has higher priority
     */
    private function resolvePhpDocInfo(\PhpParser\Node\Expr\Variable $variable) : \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $expression = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression instanceof \PhpParser\Node) {
            return $this->phpDocInfoFactory->createFromNodeOrEmpty($expression);
        }
        return $this->phpDocInfoFactory->createFromNodeOrEmpty($variable);
    }
}
