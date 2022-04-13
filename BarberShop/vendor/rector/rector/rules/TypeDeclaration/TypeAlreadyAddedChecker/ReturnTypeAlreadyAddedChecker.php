<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeAlreadyAddedChecker;

use Iterator;
use PhpParser\Node\ComplexType;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Traversable;
final class ReturnTypeAlreadyAddedChecker
{
    /**
     * @var string[]|class-string<Traversable>[]
     */
    private const FOREACHABLE_TYPES = ['iterable', 'Iterator', 'Traversable', 'array'];
    /**
     * @readonly
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @readonly
     * @var \Rector\StaticTypeMapper\StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Comparing\NodeComparator
     */
    private $nodeComparator;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeComparator = $nodeComparator;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod|\PhpParser\Node\Stmt\Function_ $functionLike
     */
    public function isSameOrBetterReturnTypeAlreadyAdded($functionLike, \PHPStan\Type\Type $returnType) : bool
    {
        $nodeReturnType = $functionLike->returnType;
        /** @param Identifier|Name|NullableType|PhpParserUnionType|null $returnTypeNode */
        if ($nodeReturnType === null) {
            return \false;
        }
        $returnNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType, \Rector\PHPStanStaticTypeMapper\Enum\TypeKind::RETURN());
        if ($this->nodeComparator->areNodesEqual($nodeReturnType, $returnNode)) {
            return \true;
        }
        // is array <=> iterable <=> Iterator co-type? → skip
        if ($this->isArrayIterableIteratorCoType($nodeReturnType, $returnType)) {
            return \true;
        }
        if ($this->isUnionCoType($nodeReturnType, $returnType)) {
            return \true;
        }
        // is class-string<T> type? → skip
        if ($returnType instanceof \PHPStan\Type\Generic\GenericObjectType && $returnType->getClassName() === 'class-string') {
            return \true;
        }
        // prevent overriding self with itself
        if (!$functionLike->returnType instanceof \PhpParser\Node\Name) {
            return \false;
        }
        if ($functionLike->returnType->toLowerString() !== 'self') {
            return \false;
        }
        // skip "self" by "static" override
        if ($returnType instanceof \PHPStan\Type\ThisType) {
            return \true;
        }
        $classLike = $this->betterNodeFinder->findParentType($functionLike, \PhpParser\Node\Stmt\ClassLike::class);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \false;
        }
        $className = (string) $this->nodeNameResolver->getName($classLike);
        $nodeContent = $this->nodeComparator->printWithoutComments($returnNode);
        $nodeContentWithoutPreslash = \ltrim($nodeContent, '\\');
        return $nodeContentWithoutPreslash === $className;
    }
    /**
     * @param \PhpParser\Node\ComplexType|\PhpParser\Node\Identifier|\PhpParser\Node\Name $returnTypeNode
     */
    private function isArrayIterableIteratorCoType($returnTypeNode, \PHPStan\Type\Type $returnType) : bool
    {
        if (!$this->nodeNameResolver->isNames($returnTypeNode, self::FOREACHABLE_TYPES)) {
            return \false;
        }
        return $this->isStaticTypeIterable($returnType);
    }
    /**
     * @param \PhpParser\Node\ComplexType|\PhpParser\Node\Identifier|\PhpParser\Node\Name $returnTypeNode
     */
    private function isUnionCoType($returnTypeNode, \PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        // skip nullable type
        if ($type->isSuperTypeOf(new \PHPStan\Type\NullType())->yes()) {
            return \false;
        }
        $classMethodReturnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnTypeNode);
        return $classMethodReturnType->isSuperTypeOf($type)->yes();
    }
    private function isStaticTypeIterable(\PHPStan\Type\Type $type) : bool
    {
        if ($this->isArrayIterableOrIteratorType($type)) {
            return \true;
        }
        if ($type instanceof \PHPStan\Type\UnionType || $type instanceof \PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $joinedType) {
                if (!$this->isStaticTypeIterable($joinedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
    private function isArrayIterableOrIteratorType(\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \PHPStan\Type\IterableType) {
            return \true;
        }
        if (!$type instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $type->getClassName() === \Iterator::class;
    }
}
