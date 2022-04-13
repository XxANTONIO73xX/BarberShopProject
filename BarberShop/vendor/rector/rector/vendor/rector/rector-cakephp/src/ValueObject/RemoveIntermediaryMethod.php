<?php

declare (strict_types=1);
namespace Rector\CakePHP\ValueObject;

final class RemoveIntermediaryMethod
{
    /**
     * @var string
     */
    private $firstMethod;
    /**
     * @var string
     */
    private $secondMethod;
    /**
     * @var string
     */
    private $finalMethod;
    public function __construct(string $firstMethod, string $secondMethod, string $finalMethod)
    {
        $this->firstMethod = $firstMethod;
        $this->secondMethod = $secondMethod;
        $this->finalMethod = $finalMethod;
    }
    public function getFirstMethod() : string
    {
        return $this->firstMethod;
    }
    public function getSecondMethod() : string
    {
        return $this->secondMethod;
    }
    public function getFinalMethod() : string
    {
        return $this->finalMethod;
    }
}
