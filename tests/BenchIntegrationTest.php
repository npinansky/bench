<?php
declare(strict_types=1);
namespace Benchmark;
use Benchmark\Comparator\FunctionComparator;
use Benchmark\Comparator\FunctionComparatorResults;

/**
 * Benchmark Integration test
 * Class BenchIntegrationTest
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class BenchIntegrationTest extends \PHPUnit\Framework\TestCase
{
    public function testFunctionBenchmarker()
    {
        $comp = new FunctionComparator(new FunctionComparatorResults());

        $arr = range(1,100);

        // Create three spy variables used to measure the number of executions
        // of each test function, since incrementing each spy should take the same
        // amount of time, it does not actually affect the benchmark because the time
        // to update the spy is constant, so it simply drops out
        list($spyFor, $spyForEach, $spyMap) = [0,0,0];


        // map should be slowest
        $comp->addFunction('map', function() use($arr, &$spyMap){
            ++$spyMap;
            $res = array_map(function($elm) {
                return ++$elm; // prefix should faster than postfix
            }, $arr);
        });

        // foreach should be faster than map
        $comp->addFunction('foreach', function() use ($arr, &$spyForEach) {
            ++$spyForEach;
            $res = [];
            foreach ($arr as $item) {
               $res[] = ++$item;
           }
        });

        // for should be faster than map , slower than foreach
        $comp->addFunction('for', function() use ($arr, &$spyFor) {
            ++$spyFor;
            $res = [];
            for ($i = 0; $i < count($arr); $i++) {
                $res[] = ++$arr[$i];
            }
        });

        $numTestCycles = 10;
        $results = $comp->compare($numTestCycles);

        // check that our tests were run the N times we expected
        $errMsg = '%s loop expected to be executed %d times';
        $this->assertEquals($numTestCycles, $spyFor, sprintf($errMsg, 'for', $numTestCycles));
        $this->assertEquals($numTestCycles, $spyForEach,sprintf($errMsg, 'for each', $numTestCycles));
        $this->assertEquals($numTestCycles, $spyMap, sprintf($errMsg, 'map', $numTestCycles));

        // validate results
        $this->assertInstanceOf( FunctionComparatorResults::class, $results);
        $this->assertInstanceOf( ComparatorResultsInterface::class, $results);


        $this->assertCount($numTestCycles, $results->getTestResults('for'));
        $this->assertCount($numTestCycles, $results->getTestResults('map'));
        $this->assertCount($numTestCycles, $results->getTestResults('foreach'));

        
    }
}
