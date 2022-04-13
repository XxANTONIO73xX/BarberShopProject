<?php

declare (strict_types=1);
namespace Rector\DowngradePhp80\Reflection;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ConstantType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Rector\Core\Exception\ShouldNotHappenException;
final class DefaultParameterValueResolver
{
    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function resolveFromParameterReflection(\PHPStan\Reflection\ParameterReflection $parameterReflection)
    {
        $defaultValue = $parameterReflection->getDefaultValue();
        if (!$defaultValue instanceof \PHPStan\Type\Type) {
            return null;
        }
        if (!$defaultValue instanceof \PHPStan\Type\ConstantType) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->resolveValueFromType($defaultValue);
    }
    /**
     * @param \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection $functionLikeReflection
     */
    public function resolveFromFunctionLikeAndPosition($functionLikeReflection, int $position) : ?\PhpParser\Node\Expr
    {
        $parametersAcceptor = $functionLikeReflection->getVariants()[0] ?? null;
        if (!$parametersAcceptor instanceof \PHPStan\Reflection\ParametersAcceptor) {
            return null;
        }
        $parameterReflection = $parametersAcceptor->getParameters()[$position] ?? null;
        if (!$parameterReflection instanceof \PHPStan\Reflection\ParameterReflection) {
            return null;
        }
        return $this->resolveFromParameterReflection($parameterReflection);
    }
    /**
     * @return \PhpParser\Node\Expr|\PhpParser\Node\Expr\ConstFetch
     */
    private function resolveValueFromType(\PHPStan\Type\ConstantType $constantType)
    {
        if ($constantType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return $this->resolveConstantBooleanType($constantType);
        }
        if ($constantType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            $values = [];
            foreach ($constantType->getValueTypes() as $valueType) {
                if (!$valueType instanceof \PHPStan\Type\ConstantType) {
                    throw new \Rector\Core\Exception\ShouldNotHappenException();
                }
                $values[] = $this->resolveValueFromType($valueType);
            }
            return \PhpParser\BuilderHelpers::normalizeValue($values);
        }
        return \PhpParser\BuilderHelpers::normalizeValue($constantType->getValue());
    }
    private function resolveConstantBooleanType(\PHPStan\Type\Constant\ConstantBooleanType $constantBooleanType) : \PhpParser\Node\Expr\ConstFetch
    {
        $value = $constantBooleanType->describe(\PHPStan\Type\VerbosityLevel::value());
        $name = new \PhpParser\Node\Name($value);
        return new \PhpParser\Node\Expr\ConstFetch($name);
    }
}
