<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Class FunctionSigArgSetComparitor
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionSigArgSetComparitor implements ArgumentsFunctionCompatibilityInterface
{
    private $map = [
        'boolean' => 'bool',
        'integer' => 'int',
        'double'  => 'float',
        'string'  => 'string',
        'array'   => 'array',
    ];

    private $noType = ['NULL', 'resource', 'unknown type'];

    public function isCompatible(callable $func, array $args): bool
    {
        $refFunc = new \ReflectionFunction($func);
        $params = $refFunc->getParameters();

        // simple test for function() && []
        if (count($args) === 0 && count($params) === 0) {
            return true;
        }

        // more args than parameters, no bueno :(
        if (count($args) > count($params)) {
            return false;
        } elseif (count($args) < count($params)) {
            if (count($args) > 0) {
                // we have more params than arguments, this may be OK if some params have default values
                foreach (range(count($args) - 1, count($params) - 1) as $i) {
                    // so lets examine the params without matching args
                    /** @var \ReflectionParameter $refParam */
                    $refParam = $params[$i];

                    // any params without a mapped argument must be optional...
                    if (!$refParam->isOptional()) {
                        return false;
                    }
                }
            }
        }

        foreach (range(0, count($params) - 1) as $i) {
            /** @var \ReflectionParameter $refParam */
            $refParam = $params[$i];


            // if we've hit the end of the arguments and still have more params, dont worry bc we
            // already validated above that there are enough defaults to cover
            if (count($args) > 0 && $i > count($args) - 1) {
                return true;
            }

            // empty args list, 1st param not optional
            if (count($args) === 0 && ! $refParam->isOptional()) {
                return false;
            }

            // weird edge case where param is typed|null and argument is null
            if ($refParam->isOptional() && $refParam->getDefaultValue() === null && $args[$i] === null) {
                continue;
            }

            // if the param is type-hinted make sure the arg matches types
            if ($refParam->hasType()) {
                $argType = gettype($args[$i]);
                $paramTypeName = $refParam->getType()->getName();

                // param is not considered optional because it is not the final param, but
                // still has a null deault, and the arg list is nulling it out
                if (! $refParam->isOptional() && $refParam->isDefaultValueAvailable() &&
                    $refParam->getDefaultValue() === null
                 && $args[$i] === null) {
                    continue;
                }

                // if the param is typed but the arg is a goofy value that cant map to a typed param
                if ((!$refParam->isOptional()) && in_array($argType, $this->noType)) {
                    return false;
                }

                // object type hinting is employed but the argument is the wrong type
                if ($argType === 'object') {
                    $className = $refParam->getType()->getName();
                    if (! $args[$i] instanceof $className) {
                        return false;
                    } else {
                        continue;
                    }
                }

                if ($this->map[$argType] != $paramTypeName) {
                    return false;
                }
            }
        }

        return true;
    }
}
