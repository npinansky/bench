<?php
/**
 * Benchmark sample invoker
 */
require_once 'vendor/autoload.php';

use Benchmark\Reporter\Formatter\DwooTemplateReportFormatter;
use Benchmark\Reporter\IOReporter;


// Set up the template engine to use for report formatting
$dwoo = new \Dwoo\Core();
$dwoo->addPlugin('tab',function() {return "\t";}, false);

// Set up the report
$x = new class($dwoo) {
    /**
     * @var \Dwoo\Core
     */
    private $dwoo;

    public function __construct(\Dwoo\Core $core)
    {
        $this->dwoo = $core;
    }

    /**
     * @param string $template
     * @param resource $ioStream
     */
    public function __invoke(string $template, $ioStream)
    {
        $reporter = new IOReporter();
        $reporter->setIOStream($ioStream)
            ->run(new DwooTemplateReportFormatter($this->dwoo, $template));
    }
};


// set up the io stream which accepts the report
$stdOut = fopen('php://stdout', 'w+');

$x('view/report.tpl', $stdOut);