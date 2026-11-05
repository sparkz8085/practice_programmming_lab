<?php
session_start();
$host = getenv("DB_HOST") ?: "127.0.0.1";
$db = getenv("DB_NAME") ?: "bcac591_lab";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    exit("Database connection failed. Check the database settings in db.php.");
}
function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
function require_login(): void {
    if (empty($_SESSION["user_id"])) {
        header("Location: 17_registration_login.php");
        exit;
    }
}
?>