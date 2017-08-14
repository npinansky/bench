<?php

namespace Benchmark\Comparator;

use Benchmark\Comparator\Exception\TestStackEmptyException;
use Benchmark\ComparatorInterface;
use Benchmark\ComparatorResultsInterface;

/**
 * Class FunctionComparator
 * @package Benchmark\Comparator
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionComparator implements ComparatorInterface
{
    /**
     * @var array[]
     */
    protected $tests = [];

    /**
     * @var ComparatorResultsInterface
     */
    protected $results;

    /**
     * FunctionComparator constructor.
     * @param ComparatorResultsInterface $results
     */
    public function __construct(ComparatorResultsInterface $results)
    {
        $this->results = $results;
    }

    /**
     * Run tests.
     * {@inheritdoc}
     */
    public function compare(int $iterations): ComparatorResultsInterface
    {
        // Cowardly refuse to run without any tests
        if (count($this->tests) === 0) {
            throw new TestStackEmptyException('No tests to run.');
        }

        // run each test N times
        foreach ($this->tests as $testName => $testFunc) {
            foreach (range(1,$iterations) as $i) {
                $this->results->addTestResult($testName,$this->bench($testFunc));
            }
        }

        return $this->results;
    }

    /**
     * Run a test function and note the time
     * @param callable $test
     * @return float
     */
    protected function bench(callable $test): float
    {
        $start = microtime(true);

        call_user_func($test);

        return microtime(true) - $start;
    }

    /**
     * @return array[]
     */
    public function getFunctions(): array
    {
        return $this->tests;
    }

    /**
     * @param string $testName
     * @param callable $function
     * @return self
     */
    public function addFunction(string $testName, callable $function): self
    {
        $this->tests[$testName] = $function;
        return $this;
    }
}
