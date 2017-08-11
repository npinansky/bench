<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\Reporter\Columns\Sum;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SumSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Sum::class);
    }
}
