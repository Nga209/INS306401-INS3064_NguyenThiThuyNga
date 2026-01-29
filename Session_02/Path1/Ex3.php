<?php
$value = "25.50";

$floatValue = (float)$value;
$intValue = (int)$floatValue;

echo gettype($floatValue) . "(" . $floatValue . "), ";
echo gettype($intValue) . "(" . $intValue . ")";
?>
