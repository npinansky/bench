<?php

namespace spec\Benchmark\Comparator;

use Benchmark\Comparator\FunctionComparatorResults;
use Benchmark\ComparatorResultsInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FunctionComparatorResultsSpec
 * @package spec\Benchmark\Comparator
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionComparatorResultsSpec extends ObjectBehavior
{
    /**
     * Basic constructor tests.
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(FunctionComparatorResults::class);
        $this->shouldBeAnInstanceOf(ComparatorResultsInterface::class);
    }

    public function constructor_accepts_results()
    {
        $this->beConstructedWith(['funcA' => 1, 'funcB' => 2]);
    }

    /**
     * Constructor requires an assoc array
     */
    public function it_fails_with_bad_constructor_args()
    {
        $this->beConstructedWith(['1','2','3']);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    public function it_stores_tests_results()
    {
        $this->addTestResult('funcA',1)->shouldReturnAnInstanceOf(FunctionComparatorResults::class);
        $this->getTestResults('funcA')->shouldReturn([(float)1]);
    }
}
