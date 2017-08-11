<?php
declare(strict_types=1);


namespace spec\Benchmark\Reporter;


use Benchmark\ReportColumnInterface;
use Benchmark\ReporterInterface;
use Benchmark\ReportInterface;

/**
 * Class AbstractReporter
 * @package spec\Benchmark\Reporter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class AbstractReporter implements ReporterInterface
{
    /**
     * @var ReportInterface
     */
    protected $report;

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
    abstract public function run();

    /**
     * @return array
     */
    protected function buildReport(): array
    {
        $report = [
            'title' => $this->report->getTitle(),
            'rows'  => [],
        ];

        $results = $this->report->getResults();

        foreach ($results->getTestNames() as $testName) {
            $row = [
                'title' => $testName,
                'cols'  => [],
            ];

            $sample = $results->getTestResults($testName);

            $row['cols'] = array_map(function (ReportColumnInterface $reportColumn) use ($sample) {
                return $reportColumn->getValue($sample);
            }, $this->report->getColumns());
        }
    }
}
