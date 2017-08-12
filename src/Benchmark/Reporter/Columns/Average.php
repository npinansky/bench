<?php

namespace Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;

/**
 * Class Average
 * @package Benchmark\Reporter\Columns
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class Average implements ReportColumnInterface
{
    /**
     * {@inheritdoc}
     */
    public function getValue(array $argument): float
    {
        return (float) array_sum($argument)/count($argument);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return 'Average';
    }
}
