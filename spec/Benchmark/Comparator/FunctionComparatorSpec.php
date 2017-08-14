<?php

namespace spec\Benchmark\Comparator;

use Benchmark\Comparator\FunctionComparator;
use Benchmark\ComparatorInterface;
use Benchmark\ComparatorResultsInterface;
use Benchmark\Comparator\Exception\TestStackEmptyException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FunctionComparatorSpec
 * @package spec\Benchmark\Comparator
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionComparatorSpec extends ObjectBehavior
{
    public function let(ComparatorResultsInterface $results)
    {
        $this->beConstructedWith($results);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FunctionComparator::class);
        $this->shouldBeAnInstanceOf(ComparatorInterface::class);
    }

    public function it_accepts_functions()
    {
        $this->getFunctions()->shouldHaveCount(0);
        $this->addFunction('test function', function() {})->shouldReturnAnInstanceOf(FunctionComparator::class);
        $this->getFunctions()->shouldHaveCount(1);
    }

    public function fails_with_empty_stack()
    {
        $this->shouldThrow(new TestStackEmptyException('No tests to run.'))
            ->during('compare', [1]);
    }

    public function it_runs_tests(ComparatorResultsInterface $results)
    {
        $results->addTestResult(Argument::type('string'), Argument::type('float'))
            ->willReturn($results);

        $this->beConstructedWith($results);
        $this->addFunction('test func', function () {});
        $this->compare(1)->shouldReturnAnInstanceOf(ComparatorResultsInterface::class);
    }
}
