<?php

namespace spec\Benchmark\Reporter;

use Benchmark\ComparatorResultsInterface;
use Benchmark\ReportColumnInterface;
use Benchmark\Reporter\BasicReport;
use Benchmark\ReportInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BasicReportSpec
 * @package spec\Benchmark\Reporter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class BasicReportSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BasicReport::class);
        $this->shouldBeAnInstanceOf(ReportInterface::class);
    }

    public function it_accepts_title_in_constructor()
    {
        $this->beConstructedWith('title');
        $this->getTitle()->shouldReturn('title');
    }

    public function it_accepts_results_in_constructor(ComparatorResultsInterface $results)
    {
        $this->beConstructedWith(null, $results);
        $this->getResults()->shouldReturn($results);
    }

    public function it_has_results(ComparatorResultsInterface $results)
    {
        $this->setResults($results)->shouldReturnAnInstanceOf(ReportInterface::class);
        $this->getResults()->shouldReturn($results);
    }

    public function it_has_title()
    {
        $this->setTitle('TITLE')->shouldReturnAnInstanceOf(ReportInterface::class);
        $this->getTitle()->shouldReturn('TITLE');
    }

    public function it_has_columns(ReportColumnInterface $column)
    {
        $column->getTitle()->willReturn('title');

        $this->addColumn($column)->shouldReturnAnInstanceOf(ReportInterface::class);
        $this->getColumns()->shouldReturn([$column]);
        $this->removeColumn($column)->shouldReturnAnInstanceOf(ReportInterface::class);
        $this->getColumns()->shouldReturn([]);
    }


}
