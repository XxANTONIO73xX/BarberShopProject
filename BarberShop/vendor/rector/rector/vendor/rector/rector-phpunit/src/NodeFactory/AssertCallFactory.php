<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeFactory;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
final class AssertCallFactory
{
    /**
     * @param \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node
     * @return \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall
     */
    public function createCallWithName($node, string $name)
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            return new \PhpParser\Node\Expr\MethodCall($node->var, $name);
        }
        return new \PhpParser\Node\Expr\StaticCall($node->class, $name);
    }
}
