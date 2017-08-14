<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Interface ReporterInterface
 * @package Benchmark
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
interface ReporterInterface
{
    /**
     * @param ReportInterface $report
     */
    public function setReport(ReportInterface $report);

    /**
     * Generate report
     */
    public function run(ReportFormatterInterface $formatter): void;
}
