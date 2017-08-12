<?php
declare(strict_types=1);

namespace Benchmark\Reporter\Formatter;


use Benchmark\ReportFormatterInterface;

/**
 * Format reports in JSON format
 * Class JsonReportFormatter
 * @package Benchmark\Reporter\Formatter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class JsonReportFormatter implements ReportFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function formatReport(array $report): string
    {
        return json_encode($report);
    }
}