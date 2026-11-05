<?php
require __DIR__ . "/db.php";
$message = "";
if (isset($_GET["logout"])) {
    $_SESSION = [];
    session_destroy();
    header("Location: 17_registration_login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    if ($action === "register") {
        if ($username === "" || strlen($password) < 8) $message = "Enter a username and a password with at least 8 characters.";
        else {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
                $message = "Registration successful. You can now log in.";
            } catch (PDOException $e) { $message = "Username may already be taken."; }
        }
    } elseif ($action === "login") {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $account = $stmt->fetch();
        if ($account && password_verify($password, $account["password_hash"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $account["id"];
            $_SESSION["username"] = $account["username"];
            header("Location: 17_registration_login.php");
            exit;
        }
        $message = "Invalid username or password.";
    }
}
?>
<h2>User Registration and Login</h2>
<p><?= h($message) ?></p>
<?php if (!empty($_SESSION["user_id"])): ?>
<p>Welcome, <?= h($_SESSION["username"]) ?>. Your profile is active.</p>
<a href="?logout=1">Log out</a>
<?php else: ?>
<h3>Register</h3><form method="post"><input type="hidden" name="action" value="register"><input name="username" placeholder="Username" required><input type="password" name="password" placeholder="Password (8+ characters)" required minlength="8"><button>Register</button></form>
<h3>Login</h3><form method="post"><input type="hidden" name="action" value="login"><input name="username" placeholder="Username" required><input type="password" name="password" placeholder="Password" required><button>Login</button></form>
<?php endif; ?>