<?php

namespace Benchmark\Reporter;

use Benchmark\Reporter\Exception\InvalidIOStreamException;
use Benchmark\ReporterInterface;
use Benchmark\ReportInterface;
use spec\Benchmark\Reporter\AbstractReporter;

/**
 * Create a report and return the results to an I/O stream.
 * Class IOReporter
 * @package Benchmark\Reporter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class IOReporter extends AbstractReporter
{
    /**
     * @var ReporterInterface
     */
    private $report;

    /**
     * @var resource
     */
    private $IOStream;

    /**
     * @param resource $stream
     * @return IOReporter
     * @throws InvalidIOStreamException
     */
    public function setIOStream($stream): self
    {
        if (gettype($stream) === 'resource' && get_resource_type($stream) === 'stream') {
            $this->IOStream = $stream;
            return $this;
        }

        throw new InvalidIOStreamException();
    }
}
