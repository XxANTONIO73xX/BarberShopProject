<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpDocParser;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
/**
 * @implements PhpDocTypeMapperInterface<NullableTypeNode>
 */
final class NullableTypeMapper implements \Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @readonly
     * @var \Rector\StaticTypeMapper\PhpDocParser\IdentifierTypeMapper
     */
    private $identifierTypeMapper;
    /**
     * @readonly
     * @var \PHPStan\PhpDoc\TypeNodeResolver
     */
    private $typeNodeResolver;
    public function __construct(\Rector\StaticTypeMapper\PhpDocParser\IdentifierTypeMapper $identifierTypeMapper, \PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->identifierTypeMapper = $identifierTypeMapper;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getNodeType() : string
    {
        return \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode::class;
    }
    /**
     * @param NullableTypeNode $typeNode
     */
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $type = $typeNode->type;
        if ($type instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $type = $this->identifierTypeMapper->mapToPHPStanType($type, $node, $nameScope);
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), $type]);
        }
        // fallback to PHPStan resolver
        return $this->typeNodeResolver->resolve($typeNode, $nameScope);
    }
}
