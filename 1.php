<?php

$a = '1';
$b = &$a;
$c = &$b;


echo ($b = "2 + $a");

var_dump($c);