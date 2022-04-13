<?php

declare (strict_types=1);
namespace RectorPrefix20211231\Symplify\Astral\NodeValue\NodeValueResolver;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ConstFetch;
use RectorPrefix20211231\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use RectorPrefix20211231\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements \RectorPrefix20211231\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\RectorPrefix20211231\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function getType() : string
    {
        return \PhpParser\Node\Expr\ConstFetch::class;
    }
    /**
     * @param ConstFetch $expr
     * @return null|mixed
     */
    public function resolve(\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $constFetchName = $this->simpleNameResolver->getName($expr);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
}
