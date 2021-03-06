<?php
declare(strict_types=1);


namespace Benchmark\Reporter;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Exception\MissingColumnsException;
use Benchmark\Reporter\Exception\MissingRowsException;
use Benchmark\ReporterInterface;
use Benchmark\ReportFormatterInterface;
use Benchmark\ReportInterface;

/**
 * Class AbstractReporter
 * @package spec\Benchmark\Reporter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
abstract class AbstractReporter implements ReporterInterface
{
    /**
     * @var ReportInterface
     */
    protected $report;

    public function __construct(ReportInterface $report = null)
    {
        if ($report !== null) {
            $this->report = $report;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setReport(ReportInterface $report): self
    {
        $this->report = $report;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function run(ReportFormatterInterface $formatter): void;

    /**
     * Build the report array, it is then passed to a formatter
     * for further processing into a template, json or some other
     * type of format.
     *
     * @return array
     */
    protected function buildReport(): array
    {
        if (count($this->report->getResults()->getTestNames()) === 0) {
            throw new MissingRowsException('The results set is empty');
        }

        if (count($this->report->getColumns()) === 0) {
            throw new MissingColumnsException('The report has no columns');
        }

        $report = [
            'meta' => [
                'title'     => $this->report->getTitle(),
                'rows'      => [],
                'columns'   => [],
            ],
            'data' => []
        ];


        $results = $this->report->getResults();

        // Build rows (each row represents a test)
        foreach ($results->getTestNames() as $testName) {
            $report['meta']['rows'][] = $testName;

            // Retrieve the execution times
            $sample = $results->getTestResults($testName);


            // Build columns (each column represents a aggregation)
            foreach ($this->report->getColumns() as $column) {
                /** @var ReportColumnInterface $column */
                $colName = $column->getTitle();
                if (! in_array($colName, $report['meta']['columns'])) {
                    $report['meta']['columns'][] = $colName;
                }
                $report['data'][$testName][$colName] = $column->getValue($sample);
            }

            // TODO:  implement column based custom sorting algo
            ksort($report['data'][$testName]);
        }

        // TODO: implement column based custom sorting algo
        sort($report['meta']['columns']);

        return $report;
    }
}
