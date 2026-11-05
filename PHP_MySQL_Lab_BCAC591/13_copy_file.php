<?php
$source = __DIR__ . "/sample.txt";
$destination = __DIR__ . "/sample_copy.txt";
if (!is_file($source)) {
    file_put_contents($source, "This is sample text for the PHP file-copy exercise.");
}
echo copy($source, $destination) ? "File copied successfully." : "Unable to copy file.";
?>