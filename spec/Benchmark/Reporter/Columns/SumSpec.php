<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Columns\Sum;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SumSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Sum::class);
        $this->shouldBeAnInstanceOf(ReportColumnInterface::class);
    }

    public function it_should_compute_sum()
    {
        $this->getValue(range(1,10))->shouldReturn((float) array_sum(range(1,10)));
    }

    public function it_should_have_name()
    {
        $this->getTitle()->shouldReturn('Total');
        $this->getTitle()->shouldBeString();
    }
}
