<?php
declare(strict_types=1);


namespace Benchmark;

use Benchmark\FunctionSignatureCompatibilityInterface;

/**
 * Compare the signatures of two functions
 * Class FunctionSigComparitor
 * @package Benchmark
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class FunctionSigComparitor implements FunctionSignatureCompatibilityInterface
{
    /**
     * Compare two function signatures, determine if they are compatable
     * @param callable $func1
     * @param callable $func2
     * @return bool
     */
    public function isCompatible(callable $func1, callable $func2): bool
    {
        $refFunc1 = new \ReflectionFunction($func1);
        $refFunc2 = new \ReflectionFunction($func2);

        if ($refFunc1->getNumberOfParameters() != $refFunc2->getNumberOfParameters()) {
            return false;
        }

        if ($refFunc1->getNumberOfParameters() === $refFunc2->getNumberOfParameters()
            && $refFunc2->getNumberOfParameters() === 0 ) {
            return true;
        }

        $params1 = $refFunc1->getParameters();
        $params2 = $refFunc2->getParameters();

        foreach (range(0, $refFunc1->getNumberOfParameters()) as $i) {
            /** @var \ReflectionParameter $param1 */
            $param1 = $params1[$i];

            /** @var \ReflectionParameter $param2 */
            $param2 = $params2[$i];

            // both must be typed, or untyped
            if ($param1->hasType() != $param2->hasType()) {
                return false;
            }

            // if typed, types must match, if untyped let it pass.
            if ($param1->hasType() && $param2->hasType()) {
                if ($param1->getType()->getName() != $param2->getType()->getName()) {
                    return false;
                }
            }

            /*
             * both must be optional or req'd but if they are optional
             * we are not gonna bother checking the default type because
             * that can vary based on the implementation details of the underlying function
             */
            if ($param1->isOptional() != $param2->isOptional()) {
                return false;
            }

            return true;
        }

        return true;
    }
}