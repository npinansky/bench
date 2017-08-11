<?php

namespace spec\Benchmark\Reporter;

use Benchmark\Reporter\Exception\InvalidIOStreamException;
use Benchmark\Reporter\IOReporter;
use Benchmark\ReporterInterface;
use Benchmark\ReportInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IOReporterSpec
 * @package spec\Benchmark\Reporter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class IOReporterSpec extends ObjectBehavior
{
    public function it_is_initializable ()
    {
        $this->shouldHaveType(IOReporter::class);
        $this->shouldBeAnInstanceOf(ReporterInterface::class);
    }

    public function it_should_accept_report (ReportInterface $report)
    {
        $this->setReport($report)->shouldReturnAnInstanceOf(IOReporter::class);
    }

    public function it_should_accept_valid_IO_stream ()
    {
        $res = fopen('php://stdout', 'w+');
        $this->setIOStream($res)->shouldReturnAnInstanceOf(IOReporter::class);
    }

    public function it_should_reject_invalid_IO_stream ()
    {
        $res = 'abc';
        $this->shouldThrow(new InvalidIOStreamException())->during('setIOStream', [$res]);

        $ch = curl_init();

        $this->shouldThrow(new InvalidIOStreamException())->during('setIOStream', [$ch]);
    }
}
