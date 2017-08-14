<?php

namespace spec\Benchmark\Reporter;

use Benchmark\ComparatorResultsInterface;
use Benchmark\Reporter\Exception\InvalidIOStreamException;
use Benchmark\Reporter\Exception\MissingColumnsException;
use Benchmark\Reporter\Exception\MissingRowsException;
use Benchmark\Reporter\IOReporter;
use Benchmark\ReporterInterface;
use Benchmark\ReportFormatterInterface;
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

    /**
     * Test failure when trying to report without any columns
     */
    public function it_should_reject_empty_columns(
        ReportInterface $report,
        ComparatorResultsInterface $results,
        ReportFormatterInterface $formatter
    )
    {
        $results->getTestNames()->willReturn(['test']);
        $report->getResults()->willReturn($results);
        $report->getColumns()->willReturn([]);

        $this->setReport($report);
        $res = fopen('php://stdout', 'w+');
        $this->setIOStream($res);
        $this->shouldThrow(MissingColumnsException::class)->during('run', [$formatter]);

    }

    /**
     * Test failure when trying to report without any rows
     */
    public function it_should_reject_empty_report(
        ReportInterface $report,
        ComparatorResultsInterface $results,
        ReportFormatterInterface $formatter
    ) {
        $results->getTestNames()->willReturn([]);
        $report->getResults()->willReturn($results);

        $this->setReport($report);
        $res = fopen('php://stdout', 'w+');
        $this->setIOStream($res);
        $this->shouldThrow(MissingRowsException::class)->during('run', [$formatter]);
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

    /**
     * Test failure when using a non-stream resource object
     */
    public function it_should_reject_invalid_IO_stream ()
    {
        $res = 'abc';
        $this->shouldThrow(new InvalidIOStreamException())->during('setIOStream', [$res]);

        $ch = curl_init();

        $this->shouldThrow(new InvalidIOStreamException())->during('setIOStream', [$ch]);
    }
}
