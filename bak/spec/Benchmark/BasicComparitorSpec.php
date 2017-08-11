<?php

namespace spec\Benchmark;

use Benchmark\BasicComparitor;
use Benchmark\MethodSignatureValidator\SignatureHashGeneratorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Benchmark\ComparitorInterface;
use Benchmark\ComparitorResultsInterface;

/**
 * Spec for basic comparitor
 * Class BasicComparitorSpec
 * @package spec\Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class BasicComparitorSpec extends ObjectBehavior
{


    public function it_is_initializable()
    {
        $this->shouldHaveType(BasicComparitor::class);
        $this->shouldBeAnInstanceOf(ComparitorInterface::class);
    }

    public function it_accepts_callable()
    {
        $this->addFunction('testFunc', function () {})
            ->shouldImplement(ComparitorInterface::class);
    }

    public function it_accepts_arguments()
    {
        $this->addArgumentSet('testArgs', [])
            ->shouldImplement(ComparitorInterface::class);
    }

    public function it_compares_functions()
    {
        $this->compare(1)
            ->shouldImplement(ComparitorResultsInterface::class);
    }

}
