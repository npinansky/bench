<?php

namespace spec\Benchmark\Reporter\Columns;

use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\Columns\Average;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AverageSpec
 * @package spec\Benchmark\Reporter\Columns
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 * @link https://github.com/yvoyer/phpspec-cheat-sheet
 */
class AverageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Average::class);
        $this->beAnInstanceOf(ReportColumnInterface::class);
    }

    public function it_should_compute_average()
    {
        $this->getValue(range(1,10))->shouldReturn(5.5);
    }

    public function it_should_have_title()
    {
        $this->getTitle()->shouldBeString();
        $this->getTitle()->shouldReturn('Average');
    }
}
