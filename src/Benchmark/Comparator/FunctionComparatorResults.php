<?php
declare(strict_types=1);

namespace Benchmark\Comparator;


use Benchmark\ComparatorResultsInterface;

/**
 * Class FunctionComparatorResults
 * @package Benchmark\Comparator
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionComparatorResults implements ComparatorResultsInterface
{
    /**
     * @var array
     */
    protected $results = [];

    /**
     * FunctionComparatorResults constructor.
     * @param array|null $results Optionally pass the full results stack in the constructor
     */
    public function __construct(array $results = null)
    {
        if ( $results !== null) {
            if (! $this->isAssoc($results)) {
                throw new \InvalidArgumentException('Input array must contain test name as keys');
            }

            foreach ($results as $name => $value) {
                $this->addTestResult($name, $value);
            }
        }
    }


    /**
     * {@inheritdoc}
     */
    public function addTestResult(string $name, float $time): ComparatorResultsInterface
    {
        $this->results[$name][] = $time;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTestResults(string $name): array
    {
        return $this->results[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getTestNames(): array
    {
        return array_keys($this->results);
    }

    /**
     * {@inheritdoc}
     */
    public function removeResults(string $name): ComparatorResultsInterface
    {
        unset($this->results[$name]);
        return $this;
    }

    /**
     * Determine if an array is assoc or sequential.
     * @param array $array
     * @return bool
     */
    protected function isAssoc(array $array): bool
    {
        return ($array !== array_values($array));
    }
}