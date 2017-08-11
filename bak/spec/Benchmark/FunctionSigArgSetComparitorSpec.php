<?php

namespace spec\Benchmark;

use Benchmark\ArgumentsFunctionCompatibilityInterface;
use Benchmark\FunctionSigArgSetComparitor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FunctionSigArgSetComparitorSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FunctionSigArgSetComparitor::class);
        $this->beAnInstanceOf(ArgumentsFunctionCompatibilityInterface::class);
    }

    public function it_should_validate_params(): void
    {
        $this->isCompatible(function () {}, [])->shouldBe(true);
    }
}
