<?php

namespace Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;

/**
 * Class Sum
 * @package Benchmark\Reporter\Columns
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class Sum implements ReportColumnInterface
{
    public function getValue(array $argument): float
    {
        return (float) array_sum($argument);
    }


    public function getTitle(): string
    {
        return 'Total';
    }
}
