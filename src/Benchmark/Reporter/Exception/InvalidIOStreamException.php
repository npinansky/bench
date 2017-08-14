<?php
declare(strict_types=1);


namespace Benchmark\Reporter\Exception;

/**
 * Thrown when the user tries to pass a bad resource as the I/O stream to an IOReporter
 * Class InvalidIOStreamException
 * @package Benchmark\Reporter\Exception
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class InvalidIOStreamException extends \Exception
{
    public function __construct()
    {
        parent::__construct('You must pass a valid I/O stream resource');
    }
}
