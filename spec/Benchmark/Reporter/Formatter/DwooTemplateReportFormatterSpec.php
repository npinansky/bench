<?php

namespace spec\Benchmark\Reporter\Formatter;

use Benchmark\Reporter\Formatter\DwooTemplateReportFormatter;
use Benchmark\ReportFormatterInterface;
use Dwoo\Core;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec test for template-based report formatter
 * Class DwooTemplateReportFormatterSpec
 * @package spec\Benchmark\Reporter\Formatter
 * @author Nick Pinansky <pinansky@gmail.com>
 */
class DwooTemplateReportFormatterSpec extends ObjectBehavior
{
    private $templateFile = 'template.tpl';

    public function let(Core $dwoo)
    {
        $this->beConstructedWith($dwoo, $this->templateFile);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DwooTemplateReportFormatter::class);
        $this->shouldBeAnInstanceOf(ReportFormatterInterface::class);
    }

    public function it_should_build_template(Core $dwoo)
    {
        $dwoo->get($this->templateFile, ['report' => [1,2,3]])->willReturn('template');

        $this->formatReport([1,2,3])->shouldBe('template');
    }
}
