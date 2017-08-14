{*
REPORT TITLE: {$report.meta.title}
test name{tab}{tab}{foreach $report.meta.columns col}{$col}{tab}{/foreach}
{foreach $report.data rowName row}
{$rowName}{tab}{tab}{foreach $row key val}{$val}{tab}{/foreach}
{/foreach}
*}

<table>
    <thead>
        <tr>
            <th>{$report.meta.title}</th>
        </tr>
        <tr>
                <th>
                    Test Name
                </th>
            {foreach $report.meta.columns col}
                <th>
                    {$col}
                </th>
            {/foreach}
        </tr>
    </thead>
    <tbody>
        {foreach $report.data rowName row}
            <tr>
                <td>{$rowName}</td>
                {foreach $row key val}
                    <td>
                        {$val}
                    </td>
                {/foreach}
            </tr>
        {/foreach}
    </tbody>
</table>
