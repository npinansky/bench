<?php

namespace spec\Benchmark\Reporter\Formatter;

use Benchmark\Reporter\Formatter\JsonReportFormatter;
use Benchmark\ReportFormatterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonReportFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonReportFormatter::class);
        $this->shouldBeAnInstanceOf(ReportFormatterInterface::class);
    }

    function it_returns_json()
    {
        $this->formatReport([1,2,3])->shouldReturn('[1,2,3]');
    }
}
