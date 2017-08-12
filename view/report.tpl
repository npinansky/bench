REPORT TITLE: {$report.meta.title}
test name{tab}{foreach $report.meta.cols col}{$col}{tab}{/foreach}
{foreach $report.data rowName row}
{$rowName}{tab}{tab}{foreach array_keys($row) key}{$row.$key}{tab}{/foreach}
{/foreach}