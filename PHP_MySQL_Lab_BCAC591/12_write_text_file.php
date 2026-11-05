<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $info = trim($_POST["info"] ?? "");
    if ($info === "") $message = "Enter some information.";
    else {
        $saved = file_put_contents(__DIR__ . "/form_data.txt", $info . PHP_EOL, FILE_APPEND | LOCK_EX);
        $message = $saved === false ? "Unable to save the file." : "Information saved successfully.";
    }
}
?>
<form method="post"><label>Information <textarea name="info" required></textarea></label><button>Save to file</button></form>
<p><?= htmlspecialchars($message) ?></p>