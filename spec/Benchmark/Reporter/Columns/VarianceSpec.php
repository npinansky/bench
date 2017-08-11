<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\Reporter\Columns\Variance;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VarianceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Variance::class);
    }
}
