<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Columns\Min;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MinSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Min::class);
        $this->shouldBeAnInstanceOf(ReportColumnInterface::class);
    }

    /**
     * Compute minimum value from a list.
     */
    public function it_should_compute_min()
    {
        $this->getValue(range(1,10))->shouldReturn((float)1);
    }

    public function it_should_have_name()
    {
        $this->getTitle()->shouldReturn('Min.');
        $this->getTitle()->shouldBeString();
    }
}
