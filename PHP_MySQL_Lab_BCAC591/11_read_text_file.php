<?php
$file = __DIR__ . "/sample.txt";
if (is_readable($file)) echo nl2br(htmlspecialchars(file_get_contents($file)));
else echo "The sample.txt file is missing or unreadable.";
?>