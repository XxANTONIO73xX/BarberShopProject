<?php

declare (strict_types=1);
namespace Rector\Nette\NeonParser\NodeFactory;

use RectorPrefix20211231\Nette\Neon\Node\ArrayItemNode;
use RectorPrefix20211231\Nette\Neon\Node\ArrayNode;
use RectorPrefix20211231\Nette\Neon\Node\EntityNode;
use RectorPrefix20211231\Nette\Neon\Node\LiteralNode;
use Rector\Nette\NeonParser\Node\Service_;
use RectorPrefix20211231\Nette\Neon\Node;
use Rector\Nette\NeonParser\Node\Service_\SetupMethodCall;
final class ServiceFactory
{
    /**
     * @var string
     */
    private const CLASS_KEYWORD = 'class';
    /**
     * @var string
     */
    private const SETUP_KEYWORD = 'setup';
    /**
     * @var string
     */
    private const FACTORY_KEYWORD = 'factory';
    /**
     * @return \Rector\Nette\NeonParser\Node\Service_|null
     */
    public function create(\RectorPrefix20211231\Nette\Neon\Node $node)
    {
        if (!$node instanceof \RectorPrefix20211231\Nette\Neon\Node\ArrayItemNode) {
            return null;
        }
        $class = $this->resolveArrayItemByKeyword($node, self::CLASS_KEYWORD);
        $factory = $this->resolveArrayItemByKeyword($node, self::FACTORY_KEYWORD);
        $className = $this->resolveServiceName($class, $factory);
        // resolve later
        if (!\is_string($className)) {
            return null;
        }
        $setupMethodCalls = $this->resolveSetupMethodCalls($className, $node);
        return new \Rector\Nette\NeonParser\Node\Service_($className, $class, $factory, $setupMethodCalls);
    }
    /**
     * @return \Nette\Neon\Node\LiteralNode|null
     */
    private function resolveArrayItemByKeyword(\RectorPrefix20211231\Nette\Neon\Node\ArrayItemNode $arrayItemNode, string $keyword)
    {
        if (!$arrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\ArrayNode) {
            return null;
        }
        $arrayNode = $arrayItemNode->value;
        foreach ($arrayNode->items as $arrayItemNode) {
            if (!$arrayItemNode->key instanceof \RectorPrefix20211231\Nette\Neon\Node\LiteralNode) {
                continue;
            }
            if ($arrayItemNode->key->toString() !== $keyword) {
                continue;
            }
            if ($arrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\EntityNode) {
                return $arrayItemNode->value->value;
            }
            if ($arrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\LiteralNode) {
                return $arrayItemNode->value;
            }
        }
        return null;
    }
    /**
     * @return SetupMethodCall[]
     */
    private function resolveSetupMethodCalls(string $className, \RectorPrefix20211231\Nette\Neon\Node\ArrayItemNode $arrayItemNode) : array
    {
        if (!$arrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\ArrayNode) {
            return [];
        }
        $setupMethodCalls = [];
        $arrayNode = $arrayItemNode->value;
        foreach ($arrayNode->items as $arrayItemNode) {
            if ($arrayItemNode->key instanceof \RectorPrefix20211231\Nette\Neon\Node\LiteralNode) {
                if ($arrayItemNode->key->toString() !== self::SETUP_KEYWORD) {
                    continue;
                }
                if (!$arrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\ArrayNode) {
                    continue;
                }
                foreach ($arrayItemNode->value->items as $setupArrayItemNode) {
                    if ($setupArrayItemNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\EntityNode) {
                        // probably method call
                        $entityNode = $setupArrayItemNode->value;
                        if ($entityNode->value instanceof \RectorPrefix20211231\Nette\Neon\Node\LiteralNode) {
                            // not a method call - probably property assign
                            if (\strncmp($entityNode->value->toString(), '$', \strlen('$')) === 0) {
                                continue;
                            }
                            $setupMethodCalls[] = new \Rector\Nette\NeonParser\Node\Service_\SetupMethodCall($className, $entityNode->value, $entityNode);
                        }
                    }
                }
            }
        }
        return $setupMethodCalls;
    }
    /**
     * @param \Nette\Neon\Node\LiteralNode|null $classLiteralNode
     * @param \Nette\Neon\Node\LiteralNode|null $factoryLiteralNode
     * @return string|null
     */
    private function resolveServiceName($classLiteralNode, $factoryLiteralNode)
    {
        if ($classLiteralNode) {
            return $classLiteralNode->toString();
        }
        if ($factoryLiteralNode) {
            return $factoryLiteralNode->toString();
        }
        return null;
    }
}
