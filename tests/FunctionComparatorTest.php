<?php
declare(strict_types=1);
namespace Benchmark;

use Benchmark\Comparator\FunctionComparator;
use Benchmark\Comparator\FunctionComparatorResults;

/**
 * Class FunctionComparatorTest
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class FunctionComparatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var FunctionComparator
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new FunctionComparator(new FunctionComparatorResults());
    }

    /**
     * Hard to test inside compare() with phspec, we need
     * to check that compare($i) runs the test $i times
     */
    public function testCompare()
    {
        $testRuns = 0;

        $this->subject->addFunction('test', function () use (&$testRuns) {
            ++$testRuns;
        });

        $runs = (int) rand(2, 100); // pick a random number of executions

        $this->subject->compare($runs);

        $this->assertEquals($runs, $testRuns);
    }
}
