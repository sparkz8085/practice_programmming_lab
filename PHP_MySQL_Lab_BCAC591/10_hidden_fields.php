<?php
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$comment = $_POST["comment"] ?? "";
?>
<?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
<p><?= htmlspecialchars("Thanks for comment ...." . $name . ", " . $email) ?></p>
<?php else: ?>
<form method="post">
<label>Name <input name="name" required></label><br>
<label>Email <input type="email" name="email" required></label><br>
<label>Comment <textarea name="comment" required></textarea></label><br>
<button>Submit</button></form>
<?php endif; ?>