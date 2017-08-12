<?php
declare(strict_types=1);

namespace Benchmark\Reporter\Formatter;


use Benchmark\ReportFormatterInterface;
use Dwoo\Core;

/**
 * Formats reports using the DWOO template engine
 * Class DwooTemplateReportFormatter
 * @package Benchmark\Reporter\Formatter
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class DwooTemplateReportFormatter implements ReportFormatterInterface
{
    /**
     * @var Core
     */
    private $templateEngine;

    /**
     * @var string
     */
    private $templateFile;

    /**
     * DwooTemplateReportFormatter constructor.
     * @param Core $templateEngine
     * @param string $templateFilename
     */
    public function __construct(Core $templateEngine, string $templateFilename)
    {
        $this->templateEngine = $templateEngine;
        $this->templateFile = $templateFilename;
    }

    /**
     * {@inheritdoc}
     */
    public function formatReport(array $report): string
    {
        return $this->templateEngine->get($this->templateFile, ['report' => $report]);
    }

}