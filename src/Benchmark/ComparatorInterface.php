<?php
declare(strict_types=1);


namespace Benchmark;

use Benchmark\Comparator\Exception\TestStackEmptyException;

/**
 * Interface ComparatorInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface ComparatorInterface
{
    /**
     * ComparatorInterface constructor.
     * @param ComparatorResultsInterface $results
     */
    public function __construct(ComparatorResultsInterface $results);

    /**
     * Execute a test a given number of times and return the results
     * as a sample population.
     * @param int $iterations Number of tests to run
     * @return ComparatorResultsInterface
     * @throws TestStackEmptyException Thrown when trying to execute with an empty stack
     */
    public function compare(int $iterations): ComparatorResultsInterface;
}
