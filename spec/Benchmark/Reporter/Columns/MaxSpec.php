<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\Reporter\Columns\Max;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MaxSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Max::class);
    }
}
