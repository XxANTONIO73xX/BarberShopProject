<?php

declare (strict_types=1);
namespace Rector\Renaming\ValueObject;

final class RenamedNamespace
{
    /**
     * @readonly
     * @var string
     */
    private $currentName;
    /**
     * @readonly
     * @var string
     */
    private $oldNamespace;
    /**
     * @readonly
     * @var string
     */
    private $newNamespace;
    public function __construct(string $currentName, string $oldNamespace, string $newNamespace)
    {
        $this->currentName = $currentName;
        $this->oldNamespace = $oldNamespace;
        $this->newNamespace = $newNamespace;
    }
    public function getNameInNewNamespace() : string
    {
        return \str_replace($this->oldNamespace, $this->newNamespace, $this->currentName);
    }
}
