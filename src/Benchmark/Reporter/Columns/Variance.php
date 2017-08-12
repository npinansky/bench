<?php

namespace Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;

/**
 * Class Variance
 * @package Benchmark\Reporter\Columns
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class Variance implements ReportColumnInterface
{

    /*
     * {@inheritdoc}
     */
    public function getValue(array $sample): float
    {
        $avg = array_sum($sample)/count($sample);

        return array_sum(array_map(function ($x) use ($avg) {
            return pow($x - $avg, 2);
        }, $sample)) /count($sample);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return 'Variance';
    }
}
