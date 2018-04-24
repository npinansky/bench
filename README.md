# bench
Benchmarking System
## Overview
This is a small framework for benchmarking functions and outputting reports. It is very simple and uses microtime() in it's core.
It is also very modular and can be re-used for other things.
## Usage
You can see a simple use case in tests/BenchIntegrationTest.php

Don't forget to run composer first after cloning!
```
composer install
```


1. First set up a Comparator which is a class that is used to compare things.
You can use the constructor injection to pass it an object to hold it's result set in.

e.g.
```
$comp = new FunctionComparator(new FunctionComparatorResults());
```

2. Now let's add some code to compare whether array_map() or foreach() is more performant

```
$arr = range(1,100);


$comp->addFunction('map', function () use ($arr) {
            $res = array_map(function ($elm) {
                return ++$elm; // prefix should faster than postfix
            }, $arr);
});
        
$comp->addFunction('foreach', function () use ($arr) {
            $res = [];
            foreach ($arr as $item) {
                $res[] = ++$item;
            }
});
```

3. Now we can run them to compare the execution time of the code (or whatever comparisons the Comparator is supposed to make)
```
$results = $comp->compare($numTestCycles);
```

4. Now that we have an object with the results of our tests, lets confgure a report from it.

```
$report = new BasicReport('Loop test', $results);
```

5. Each test (in this example function) will act as a row in the report, the columns
will be represented by aggregate functions which act on the raw data. We need to add them
to the report before it can be built.

This example code will add some columns for a minimum, maximum and total for each row
```
$report->addColumn(new Min());
$report->addColumn(new Max());
$report->addColumn(new Sum());
```

5. We have a report configuration, but we need to format and out put it to somewhere.
a ReportFormatter class is used to determine *how* the data is output, a Reporter class 
is used to determine *where* it is output.

In this example let's use a temple engine to format, and an I/O stream to output it.

The IORereporter allows reports to be written to an I/O stream resource object. 

```
$reporter = new IOReporter($report);
$ioStream = fopen('php://stdout', 'w+'); // create a stream to std output
$reporter->setIOStream($ioStream);
```

Now we can use a the Dwoo template engine to build a simple report template like this:
```
REPORT TITLE: {$report.meta.title}
test name{tab}{tab}{foreach $report.meta.columns col}{$col}{tab}{/foreach}
{foreach $report.data rowName row}
{$rowName}{tab}{tab}{foreach $row key val}{$val}{tab}{/foreach}
{/foreach}
```

The bench package comes with a special ReportFormatter especially for using Dwoo. Let's configure it now:
```
// create an instance of the template engine and configure it
$templateEngine = new \Dwoo\Core();
$templateEngine->addPlugin('tab', function () {
  return "\t";
}, false);

// Using dependency injection, lets inject an instance of the report formatter, which in turn
// has the template engine preconfigured and injected into it.
$reporter->run(
  new DwooTemplateReportFormatter(
    $templateEngine, __DIR__ . '/../view/report.tpl'  
  )
)
```

When run, this should produce a nice little report in on the standard output.

## Enjoy!
-Nick Pinansky <pinansky@gmail.com>
