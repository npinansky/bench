<?php
declare(strict_types=1);


namespace Benchmark;


interface ReportColumnInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param array $sample
     * @return float
     */
    public function getValue(array $sample): float;
}
