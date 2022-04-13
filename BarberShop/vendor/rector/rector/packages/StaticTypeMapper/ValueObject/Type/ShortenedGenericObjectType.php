<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\ValueObject\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;
final class ShortenedGenericObjectType extends \PHPStan\Type\Generic\GenericObjectType
{
    /**
     * @var class-string
     * @readonly
     */
    private $fullyQualifiedName;
    /**
     * @param class-string $fullyQualifiedName
     */
    public function __construct(string $shortName, array $types, string $fullyQualifiedName)
    {
        $this->fullyQualifiedName = $fullyQualifiedName;
        parent::__construct($shortName, $types);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        $genericObjectType = new \PHPStan\Type\Generic\GenericObjectType($this->fullyQualifiedName, $this->getTypes());
        return $genericObjectType->isSuperTypeOf($type);
    }
    public function getShortName() : string
    {
        return $this->getClassName();
    }
    /**
     * @return class-string
     */
    public function getFullyQualifiedName() : string
    {
        return $this->fullyQualifiedName;
    }
}
