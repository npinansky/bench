<?php
declare(strict_types=1);
namespace Benchmark;

use Benchmark\Reporter\AbstractReporter;

class AbstractReporterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TestSubject
     */
    private $subject;

    /**
     * Execute fixture before each test.
     */
    public function setUp()
    {
        $this->subject = new TestSubject();
    }

    /**
     * Build a sample report.
     */
    public function testRun()
    {
        // Create the mock ColumnInterface
        $mockCol = $this->getMockBuilder(\Benchmark\ReportColumnInterface::class)
            ->setMethods(['getValue','getTitle'])
            ->getMockForAbstractClass();

        $mockCol->expects($this->once())
            ->method('getTitle')
            ->willReturn('Total');

        $mockCol->expects($this->once())
            ->method('getValue')
            ->with($this->callback(function (array $args) {
                $this->assertEquals($args, [1,2,3]);
                return true;
            }))->willReturn(1);

        // Create Test Results
        /** @var \Benchmark\ComparatorResultsInterface $mockResults */
        $mockResults = $this->getMockBuilder(\Benchmark\ComparatorResultsInterface::class)
            ->setMethods(['getTestResults','getTestNames'])
            ->getMockForAbstractClass();

        $mockResults->expects($this->once())
            ->method('getTestResults')
            ->with($this->equalTo('TEST_NAME'))
            ->willReturn([1,2,3]);

        $mockResults->expects($this->atLeastOnce())
            ->method('getTestNames')
            ->willReturn(['TEST_NAME']);

        // Create a mockReportInterface
        /** @var \Benchmark\ReportInterface $mockReport */
        $mockReport = $this->getMockBuilder(\Benchmark\ReportInterface::class)
            ->setMethods(['getResults', 'getColumns', 'getTitle'])
            ->getMockForAbstractClass();

        $mockReport->expects($this->once())
            ->method('getTitle')
            ->willReturn('REPORT_TITLE');

        // Return a ComparatorResults object
        $mockReport->expects($this->atLeastOnce())
            ->method('getResults')
            ->willReturn($mockResults);

        // Return a column object(s)
        $mockReport->expects($this->atLeastOnce())
            ->method('getColumns')
            ->willReturn([$mockCol]);

        $this->subject->setReport($mockReport);

        // Build a mock Formatter to inject into the report builder
        $mockFormatter = $this->getMockBuilder(\Benchmark\ReportFormatterInterface::class)
            ->setMethods(['formatReport'])
            ->getMockForAbstractClass();

        // Validate the report format
        $mockFormatter->expects($this->once())
            ->method('formatReport')
            ->with($this->callback(function (array $res) {

                // Validate the metadata element.
                $this->assertInternalType('array', $res);
                $this->assertArrayHasKey('meta', $res);
                $this->assertInternalType('array', $res['meta']);
                $this->assertArrayHasKey('title', $res['meta']);
                $this->assertEquals('REPORT_TITLE', $res['meta']['title']);

                // Check "rows" sub-element of metadata block
                $this->assertArrayHasKey('rows', $res['meta']);
                $this->assertInternalType('array', $res['meta']['rows']);
                $this->assertCount(1,$res['meta']['rows']);
                $this->assertEquals('TEST_NAME', $res['meta']['rows'][0]);

                // Check "columns" sub-elem of metadata block
                $this->assertArrayHasKey('columns', $res['meta']);
                $this->assertInternalType('array', $res['meta']['columns']);
                $this->assertCount(1, $res['meta']['columns']);
                $this->assertEquals('Total', $res['meta']['columns'][0]);


                // Validate the "data" element
                $this->assertArrayHasKey('data', $res);
                $this->assertInternalType('array', $res['data']);

                // Validate "TEST_NAME" sub-elem
                $this->assertArrayHasKey('TEST_NAME', $res['data']);
                $this->assertInternalType('array', $res['data']['TEST_NAME']);
                $this->assertCount(1, $res['data']['TEST_NAME']);

                // Validate columns sub-elem of TEST_NAME
                $this->assertArrayHasKey('Total', $res['data']['TEST_NAME']);
                $this->assertInternalType(
                    \PHPUnit\Framework\Constraint\IsType::TYPE_NUMERIC,
                    $res['data']['TEST_NAME']['Total']
                );
                $this->assertEquals(1, $res['data']['TEST_NAME']['Total']);

                return true;
            }));

        $this->subject->run($mockFormatter);
    }
}

/**
 * Make a concrete implementation of the abstract class we are testing
 * Class TestSubject
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class TestSubject extends  AbstractReporter
{
    /**
     * {@inheritdoc}
     */
    public function run(\Benchmark\ReportFormatterInterface $formatter): void
    {
        $formatter->formatReport($this->buildReport());
    }
}
