<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Columns\Variance;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VarianceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Variance::class);
        $this->shouldBeAnInstanceOf(ReportColumnInterface::class);
    }

    public function it_should_compute_variance()
    {
        $this->getValue(range(1,10))->shouldReturn(
            $this->getVariance(range(1,10)));
    }

    public function it_should_have_title()
    {
        return $this->getTitle()->shouldReturn('Variance');
    }

    private function getVariance(array $sample)
    {
        $avg = array_sum($sample)/count($sample);

        return array_sum(array_map(function ($x) use ($avg) {
           return pow($x - $avg, 2);
        }, $sample))/count($sample);
    }
}
