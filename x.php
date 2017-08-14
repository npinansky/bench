<?php
$x = 0;

++$x;

var_dump($x);

//var_dump([1]===[2]);

//var_dump(isAssoc([1=>2]));

function isAssoc(array $array): bool
    {
        return ($array !== array_values($array));
    }
