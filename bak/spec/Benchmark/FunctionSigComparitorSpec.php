<?php

namespace spec\Benchmark;

use Benchmark\FunctionSigComparitor;
use Benchmark\FunctionSignatureCompatibilityInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FunctionSigComparitorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FunctionSigComparitor::class);
        $this->beAnInstanceOf(FunctionSignatureCompatibilityInterface::class);
    }

    public function it_can_compare()
    {
        $this->isCompatible(function() {}, function() {})->shouldBe(true);
        $this->isCompatible(function(string $a) {}, function () {})->shouldBe(false);
    }
}
