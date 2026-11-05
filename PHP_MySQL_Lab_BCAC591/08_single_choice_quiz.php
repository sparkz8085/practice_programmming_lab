<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answer = $_POST["answer"] ?? "";
    if ($answer === "") $message = "You must select one answer.";
    elseif ($answer === "php") $message = "Your answer is correct.";
    else $message = "Your answer is incorrect.";
}
?>
<form method="post"><p>Which language is commonly used for server-side web development?</p><label><input type="radio" name="answer" value="html"> HTML</label><br><label><input type="radio" name="answer" value="php"> PHP</label><br><label><input type="radio" name="answer" value="css"> CSS</label><br><button>Submit</button></form>
<p><?= htmlspecialchars($message) ?></p>