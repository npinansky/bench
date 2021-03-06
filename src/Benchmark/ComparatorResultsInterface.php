<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Interface ComparatorResultsInterface
 * @package Benchmark
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
interface ComparatorResultsInterface
{
    /**
     * Add the result of a test run.
     * @param string $name
     * @param float $time
     * @return ComparatorResultsInterface
     */
    public function addTestResult(string $name, float $time): self;

    /**
     * Get the sample population for given test name.
     * @param string $name
     * @return array
     */
    public function getTestResults(string $name): array;

    /**
     * Get a list of each test names
     * @return string[]
     */
    public function getTestNames(): array;

    /**
     * Clear out the population for a given test.
     * @param string $name
     * @return ComparatorResultsInterface
     */
    public function removeResults(string $name): self;
}
