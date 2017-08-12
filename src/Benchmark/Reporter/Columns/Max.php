<?php

namespace Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;

/**
 * Compute maximum value.
 * Class Max
 * @package Benchmark\Reporter\Columns
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class Max implements ReportColumnInterface
{
    /**
     * {@inheritdoc}
     */
    public function getValue(array $argument): float
    {
        return (float) max($argument);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return 'Max.';
    }
}
