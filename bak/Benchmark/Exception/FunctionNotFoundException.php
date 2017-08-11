<?php
declare(strict_types=1);


namespace Benchmark\Exception;

/**
 * Class FunctionNotFoundException
 * @package Benchmark\Exception
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionNotFoundException extends \Exception
{
    public function __construct(string $functionName)
    {
        parent::__construct(sprintf('No function found with the name %s', $functionName));
    }
}