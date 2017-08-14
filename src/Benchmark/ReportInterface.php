<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Build a report based on the benchmark results
 * Interface ReportInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface ReportInterface
{
    /**
     * Add the popultion of run times (rows) to the report
     * @param ComparatorResultsInterface $results
     * @return ReportInterface
     */
    public function setResults(ComparatorResultsInterface $results): self;

    /**
     * @return ComparatorResultsInterface
     */
    public function getResults(): ComparatorResultsInterface;

    /**
     * Add a column (calculation type) to the report (eg. max, min, avg, stddev, total)
     * @param ReportColumnInterface $column
     * @return ReportInterface
     */
    public function addColumn(ReportColumnInterface $column): self;

    /**
     * Remove a column from the report
     * @param ReportColumnInterface $column
     * @return ReportInterface
     */
    public function removeColumn(ReportColumnInterface $column): self;

    /**
     * Get a list of columns
     * @return ReportColumnInterface[]
     */
    public function getColumns(): array;

    /**
     * @TODO: ADD FUNCTIONALITY FOR SORTING
     */
    // public function setOrderBy(ReportColumnInterface $column): self

    /**
     * Set report title
     * @param string $title
     * @return ReportInterface
     */
    public function setTitle(string $title): self;

    /**
     * Get report title
     * @return string
     */
    public function getTitle(): string;
}
