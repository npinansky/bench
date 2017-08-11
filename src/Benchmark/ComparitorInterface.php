<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Interface ComparitorInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface ComparitorInterface
{
    /**
     * Execute a test a given number of times and return the results
     * as a sample population.
     * @param int $iterations Number of tests to run
     * @return ComparitorResultsInterface
     */
    public function compare(int $iterations): ComparitorResultsInterface;
}
