<?php
$days = array("Monday", "Tuesday", "Wednesday");
$months = array("Jan" => "January", "Feb" => "February", "Mar" => "March");
foreach ($days as $day) echo htmlspecialchars($day) . "<br>";
foreach ($months as $short => $full) echo htmlspecialchars($short . " => " . $full) . "<br>";
sort($days);
echo "<h3>Sorted days</h3>";
foreach ($days as $day) echo htmlspecialchars($day) . "<br>";
?>