<?php
$message = "";
$name = "";
$email = "";
$comment = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $comment = trim($_POST["comment"] ?? "");
    if ($name === "" || $email === "" || $comment === "") $message = "Please complete every field.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $message = "Enter a valid email address.";
    else $message = "Thank you, " . $name . ". We will reply to your email.";
}
?>
<form method="post"><label>Name <input name="name" value="<?= htmlspecialchars($name) ?>" required></label><br><label>Email <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required></label><br><label>Comment <textarea name="comment" required><?= htmlspecialchars($comment) ?></textarea></label><br><button>Submit</button></form>
<p><?= htmlspecialchars($message) ?></p>