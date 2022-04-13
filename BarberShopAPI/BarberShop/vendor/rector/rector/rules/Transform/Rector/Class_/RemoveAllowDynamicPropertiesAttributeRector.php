<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Contract\Rector\AllowEmptyConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Php80\NodeAnalyzer\PhpAttributeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20211231\Webmozart\Assert\Assert;
/**
 * @changelog https://wiki.php.net/rfc/deprecate_dynamic_properties
 *
 * @see \Rector\Tests\Transform\Rector\Class_\RemoveAllowDynamicPropertiesAttributeRector\RemoveAllowDynamicPropertiesAttributeRectorTest
 */
final class RemoveAllowDynamicPropertiesAttributeRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\AllowEmptyConfigurableRectorInterface
{
    /**
     * @var string
     */
    private const ATTRIBUTE = 'AllowDynamicProperties';
    /**
     * @var array<array-key, string>
     */
    private $transformOnNamespaces = [];
    /**
     * @readonly
     * @var \Rector\Php80\NodeAnalyzer\PhpAttributeAnalyzer
     */
    private $phpAttributeAnalyzer;
    public function __construct(\Rector\Php80\NodeAnalyzer\PhpAttributeAnalyzer $phpAttributeAnalyzer)
    {
        $this->phpAttributeAnalyzer = $phpAttributeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the `AllowDynamicProperties` attribute from all classes', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
namespace Example\Domain;

#[AllowDynamicProperties]
class SomeObject {
    public string $someProperty = 'hello world';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace Example\Domain;

class SomeObject {
    public string $someProperty = 'hello world';
}
CODE_SAMPLE
, ['Example\\*'])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    public function configure(array $configuration) : void
    {
        $transformOnNamespaces = $configuration;
        \RectorPrefix20211231\Webmozart\Assert\Assert::allString($transformOnNamespaces);
        $this->transformOnNamespaces = $transformOnNamespaces;
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldRemove($node)) {
            return $this->removeAllowDynamicPropertiesAttribute($node);
        }
        return null;
    }
    private function removeAllowDynamicPropertiesAttribute(\PhpParser\Node\Stmt\Class_ $class) : \PhpParser\Node\Stmt\Class_
    {
        $newAttrGroups = [];
        foreach ($class->attrGroups as $attrGroup) {
            $newAttrs = [];
            foreach ($attrGroup->attrs as $attribute) {
                if (!$this->nodeNameResolver->isName($attribute, self::ATTRIBUTE)) {
                    $newAttrs[] = $attribute;
                }
            }
            $attrGroup->attrs = $newAttrs;
            if ($attrGroup->attrs !== []) {
                $newAttrGroups[] = $attrGroup;
            }
        }
        $class->attrGroups = $newAttrGroups;
        return $class;
    }
    private function shouldRemove(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->transformOnNamespaces !== []) {
            $className = (string) $this->nodeNameResolver->getName($class);
            foreach ($this->transformOnNamespaces as $transformOnNamespace) {
                if (!$this->nodeNameResolver->isStringName($className, $transformOnNamespace)) {
                    return \false;
                }
            }
        }
        return $this->phpAttributeAnalyzer->hasPhpAttribute($class, self::ATTRIBUTE);
    }
}
