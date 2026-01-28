<?php
$number = "25.50";

$floatNum = (float)$number;
$intNum = (int)$floatNum;

echo gettype($floatNum) . "(" . $floatNum . ")" . "<br>";
echo gettype($intNum) . "(" . $intNum . ")";
?>