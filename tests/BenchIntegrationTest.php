<?php
declare(strict_types=1);
namespace Benchmark;
use Benchmark\Comparator\FunctionComparator;
use Benchmark\Comparator\FunctionComparatorResults;
use Benchmark\Reporter\BasicReport;
use Benchmark\Reporter\Columns\Max;
use Benchmark\Reporter\Columns\Min;
use Benchmark\Reporter\Columns\Sum;
use Benchmark\Reporter\Formatter\DwooTemplateReportFormatter;
use Benchmark\Reporter\Formatter\JsonReportFormatter;
use Benchmark\Reporter\IOReporter;
use Dwoo\Core;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

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


        $comp->addFunction('map', function() use($arr, &$spyMap){
            ++$spyMap;
            $res = array_map(function($elm) {
                return ++$elm; // prefix should faster than postfix
            }, $arr);
        });

        $comp->addFunction('foreach', function() use ($arr, &$spyForEach) {
            ++$spyForEach;
            $res = [];
            foreach ($arr as $item) {
               $res[] = ++$item;
           }
        });

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


        // Create a new report
        $report = new BasicReport('Loop test', $results);

        // Create some columns
        $report->addColumn(new Min());
        $report->addColumn(new Max());
        $report->addColumn(new Sum());


        $reporter = new IOReporter($report);

        // Flip the status of buildReport() so we can run it from the test harness
        // and check its output, we could also subclass it to create a spy method
        // that is public accessible
        $refReport = new \ReflectionClass($reporter);
        $refBuildReport = $refReport->getMethod('buildReport');
        $refBuildReport->setAccessible(true);
        $arrReport = $refBuildReport->invoke($reporter);


        $templateEngine = new Core();
        $templateEngine->addPlugin('tab', function() { return "\t";}, false);


        $ioStream = fopen('php://stdout', 'w+');
        $reporter->setIOStream($ioStream)
            ->run(
                new DwooTemplateReportFormatter($templateEngine, __DIR__ . '/../view/report.tpl')
            );

        // verify report is correct
        $this->assertInternalType('array', $arrReport);
        $this->assertArrayHasKey('meta', $arrReport);
        $this->assertInternalType('array', $arrReport['meta']);

        //verify title
        $this->assertArrayHasKey('title', $arrReport['meta']);
        $this->assertInternalType('string', $arrReport['meta']['title']);
        $this->assertEquals($arrReport['meta']['title'], 'Loop test');


        //verify cols
        $this->assertArrayHasKey('columns', $arrReport['meta']);
        $this->assertInternalType('array', $arrReport['meta']['columns']);
        $this->assertEquals(['Max.','Min.', 'Total'], $arrReport['meta']['columns']);

        //verify rows
        $this->assertArrayHasKey('rows', $arrReport['meta']);
        $this->assertInternalType('array', $arrReport['meta']['rows']);
        $this->assertEquals(['map','foreach','for'], $arrReport['meta']['rows']);

        //verify data
        $this->assertArrayHasKey('data', $arrReport);
        foreach (['map', 'foreach','for'] as $key) {
            $this->assertArrayHasKey($key, $arrReport['data']);
            $this->assertInternalType('array', $arrReport['data'][$key]);
            foreach (['Max.', 'Min.', 'Total'] as $col) {
                $this->assertArrayHasKey($col, $arrReport['data'][$key]);
                $this->assertInternalType('float', $arrReport['data'][$key][$col]);
            }
        }

    }
}


