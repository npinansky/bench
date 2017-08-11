<?php

namespace Benchmark;
use Benchmark\Exception\ArgumentSetNotFoundException;
use Benchmark\Exception\FunctionNotFoundException;
use Benchmark\Exception\FunctionSignatureMismatchException;

/**
 * Basic Benchmarking Comparitor
 *
 * Class BasicComparitor
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class BasicComparitor implements ComparitorInterface
{
    /**
     * A list of callables
     * @var array
     */
    private $functions = [];

    /**
     * Array of argument sets
     * @var array[]
     */
    private $args = [];

    /**
     * Service to determine if two functions are compatible with eachother
     * @var FunctionSignatureCompatibilityInterface
     */
    private $functionComparitor;

    /**
     * {@inheritdoc}
     */
    public function __construct(FunctionSignatureCompatibilityInterface $funcCompare)
    {
        $this->functionComparitor = $funcCompare;
    }

    /**
     * {@inheritdoc}
     */
    public function addFunction(string $name, callable $func): ComparitorInterface
    {
        // Unless this is the first function we're adding, validate the signatures are OK
        if (count($this->functions) > 0) {
            // Get a function off the stack to compare for reference.
            $refFunc = array_values($this->functions)[0];

            // If sig doesnt match throw an exception
            if (! $this->functionComparitor->isCompatible($refFunc, $func)) {
                throw new FunctionSignatureMismatchException($refFunc);
            }
        } elseif (count($this->args) > 0) {
            // If args were added first, make sure they are compatabile with the function being added
        }

        $this->functions[$name] = $func;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFunction(string $name): ComparitorInterface
    {
        if (array_key_exists($name, $this->functions)) {
            unset($this->functions[$name]);

            // If the stack is empty, clear out the reference signature
            if (count($this->functions) === 0) {
                $this->sigHash = null;
            }
            return $this;
        }

        throw new FunctionNotFoundException($name);
    }

    /**
     * {@inheritdoc}
     */
    public function removeArgumentSet(string $name): ComparitorInterface
    {
        if (array_key_exists($name, $this->args)) {
            unset($this->args[$name]);
            return $this;
        }

        throw new ArgumentSetNotFoundException($name);
    }

    /**
     * {@inheritdoc}
     */
    public function addArgumentSet(string $name, array $args): ComparitorInterface
    {
        $this->args[$name] = $args;
    }

    /**
     * {@inheritdoc}
     */
    public function compare(int $iterations): ComparitorResultsInterface
    {
    }
}
