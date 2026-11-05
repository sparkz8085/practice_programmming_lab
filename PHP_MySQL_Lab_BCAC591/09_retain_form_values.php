<?php
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$age = $_POST["age"] ?? "";
$gender = $_POST["gender"] ?? "";
$submitted = $_SERVER["REQUEST_METHOD"] === "POST";
?>
<form method="post">
<label>Name <input name="name" value="<?= htmlspecialchars($name) ?>" required></label><br>
<label>Email <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required></label><br>
<label>Age <input type="number" name="age" min="1" max="120" value="<?= htmlspecialchars((string)$age) ?>" required></label><br>
<label>Gender <select name="gender" required><option value="">Select</option><?php foreach (["Male","Female","Other"] as $g): ?><option value="<?= $g ?>" <?= $gender === $g ? "selected" : "" ?>><?= $g ?></option><?php endforeach; ?></select></label><br>
<button>Submit</button></form>
<?php if ($submitted): ?><p>Name: <?= htmlspecialchars($name) ?><br>Age: <?= htmlspecialchars((string)$age) ?><br>Gender: <?= htmlspecialchars($gender) ?></p><?php endif; ?>