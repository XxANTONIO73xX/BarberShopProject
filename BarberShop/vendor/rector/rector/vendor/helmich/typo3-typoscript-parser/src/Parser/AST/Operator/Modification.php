<?php

declare (strict_types=1);
namespace RectorPrefix20211231\Helmich\TypoScriptParser\Parser\AST\Operator;

use RectorPrefix20211231\Helmich\TypoScriptParser\Parser\AST\ObjectPath;
/**
 * A modification statement.
 *
 * Example:
 *
 *     foo  = bar
 *     foo := appendToString(baz)
 *
 * @package    Helmich\TypoScriptParser
 * @subpackage Parser\AST\Operator
 */
class Modification extends \RectorPrefix20211231\Helmich\TypoScriptParser\Parser\AST\Operator\BinaryOperator
{
    /**
     * The modification call.
     *
     * @var ModificationCall
     */
    public $call;
    /**
     * Constructs a modification statement.
     *
     * @param ObjectPath       $object     The object to modify.
     * @param ModificationCall $call       The modification call.
     * @param int              $sourceLine The original source line.
     */
    public function __construct(\RectorPrefix20211231\Helmich\TypoScriptParser\Parser\AST\ObjectPath $object, \RectorPrefix20211231\Helmich\TypoScriptParser\Parser\AST\Operator\ModificationCall $call, int $sourceLine)
    {
        parent::__construct($sourceLine);
        $this->object = $object;
        $this->call = $call;
    }
}
