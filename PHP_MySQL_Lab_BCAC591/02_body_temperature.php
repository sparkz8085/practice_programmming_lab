<?php
$body_temp = 98.6;
$celsius = ($body_temp - 32) * 5 / 9;
echo "Normal temperature - " . $body_temp . "<br>";
echo "Body temperature is " . $body_temp . " degrees Fahrenheit (" . round($celsius) . " degrees Celsius)";
?>