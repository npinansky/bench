<?php
declare(strict_types=1);

namespace Benchmark;

/**
 * Formats a report for display or further use
 * Interface ReportFormatterInterface
 * @package Benchmark
 */
interface ReportFormatterInterface
{
    /**
     * Create the report from an array
     * @param array $report
     * @return string
     */
    public function formatReport(array $report): string;
}
