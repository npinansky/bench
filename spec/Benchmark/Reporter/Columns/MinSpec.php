<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\Reporter\Columns\Min;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MinSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Min::class);
    }
}
