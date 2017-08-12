<?php

namespace Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;

class Min implements ReportColumnInterface
{
    /**
     * {@inheritdoc}
     */
    public function getValue(array $argument): float
    {
        return (float) min($argument);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return 'Min.';
    }
}
