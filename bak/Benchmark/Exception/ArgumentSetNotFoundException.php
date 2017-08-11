<?php
declare(strict_types=1);


namespace Benchmark\Exception;


/**
 * Class ArgumentSetNotFoundException
 * @package Benchmark\Exception
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class ArgumentSetNotFoundException extends \Exception
{
    public function __construct(string $argSetName)
    {
        parent::__construct(sprintf('No argument set found named %s', $argSetName));
    }
}