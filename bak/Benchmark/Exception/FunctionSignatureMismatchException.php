<?php

namespace Benchmark\Exception;

use Throwable;

/**
 * Exception thrown when adding a test function with arguments that mismatch other functions added.
 * Class FunctionSignatureMismatchException
 * @package Benchmark\Exception
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionSignatureMismatchException extends \Exception
{
    public function __construct(callable $referenceFunction)
    {
        parent::__construct(sprintf('Function does not match expected signature: %s',
            $this->buildExampleSig($referenceFunction)));
    }

    /**
     * Build an example func signature given a callable
     * @param callable $func
     * @return string
     */
    private function buildExampleSig(callable $func): string
    {
        $ref = new \ReflectionFunction($func);

        $sig = [];

        foreach ($ref->getParameters() as $parameter) {
            $sig[] = ($parameter->isOptional())
                ? '[' . $this->getParameterSig($parameter) . ']'
                : $this->getParameterSig($parameter);
        }

        return sprintf('function (%s)', implode(', ', $sig));
    }

    /**
     * @param \ReflectionParameter $parameter
     * @return string
     */
    private function getParameterSig(\ReflectionParameter $parameter): string
    {
        return ($parameter->hasType())
            ? sprintf('%s $%s', $parameter->getType()->getName(), $parameter->getName())
            : sprintf('$%s', $parameter->getName());
    }
}
