<?php

namespace Benchmark\Reporter;

use Benchmark\ComparatorResultsInterface;
use Benchmark\ReportColumnInterface;
use Benchmark\ReportInterface;

class BasicReport implements ReportInterface
{
    /**
     * @var ComparatorResultsInterface
     */
    protected $results;

    /**
     * @var ReportColumnInterface[]
     */
    protected $columns = [];

    /**
     * @var string
     */
    protected $reportTitle = '';

    /**
     * BasicReport constructor.
     * @param string $title
     * @param ComparatorResultsInterface|null $results
     */
    public function __construct(string $title = null, ComparatorResultsInterface $results = null)
    {
        if ($title !== null) {
            $this->setTitle($title);
        }

        if ($results !== null) {
            $this->setResults($results);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(): ComparatorResultsInterface
    {
        return $this->results;
    }


    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->reportTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title): ReportInterface
    {
        $this->reportTitle = $title;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addColumn(ReportColumnInterface $column): ReportInterface
    {
        $this->columns[$column->getTitle()] = $column;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeColumn(ReportColumnInterface $column): ReportInterface
    {
        unset($this->columns[$column->getTitle()]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns(): array
    {
        return array_values($this->columns);
    }


    /**
     * {@inheritdoc}
     */
    public function setResults(ComparatorResultsInterface $comparatorResults): ReportInterface
    {
        $this->results = $comparatorResults;
        return $this;
    }
}
