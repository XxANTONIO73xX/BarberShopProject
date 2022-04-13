<?php

declare (strict_types=1);
namespace Rector\PhpAttribute\AnnotationToAttributeMapper;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name;
use Rector\PhpAttribute\Contract\AnnotationToAttributeMapperInterface;
/**
 * @implements AnnotationToAttributeMapperInterface<string>
 */
final class ClassConstFetchAnnotationToAttributeMapper implements \Rector\PhpAttribute\Contract\AnnotationToAttributeMapperInterface
{
    /**
     * @param mixed $value
     */
    public function isCandidate($value) : bool
    {
        if (!\is_string($value)) {
            return \false;
        }
        return \strpos($value, '::') !== \false;
    }
    /**
     * @param string $value
     */
    public function map($value) : \PhpParser\Node\Expr\ClassConstFetch
    {
        [$class, $constant] = \explode('::', $value);
        return new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name($class), $constant);
    }
}
