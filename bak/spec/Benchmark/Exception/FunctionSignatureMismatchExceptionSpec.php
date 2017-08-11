<?php

namespace spec\Benchmark\Exception;

use Benchmark\Exception\FunctionSignatureMismatchException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FunctionSignatureMismatchExceptionSpec
 * @package spec\Benchmark\Exception
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionSignatureMismatchExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(FunctionSignatureMismatchException::class);
        $this->shouldBeAnInstanceOf(\Exception::class);
    }
}
