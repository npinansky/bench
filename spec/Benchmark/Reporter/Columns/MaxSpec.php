<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Columns\Max;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MaxSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Max::class);
        $this->shouldBeAnInstanceOf(ReportColumnInterface::class);
    }

    public function it_should_compute_max()
    {
        $this->getValue(range(1,10))->shouldReturn((float)10);
    }

    public function it_should_have_title()
    {
        $this->getTitle()->shouldReturn('Max.');
        $this->getTitle()->shouldBeString();
    }
}
