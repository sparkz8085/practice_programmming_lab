<?php
require __DIR__ . "/db.php";
require_login();
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $title = trim($_POST["title"] ?? "");
    $body = trim($_POST["body"] ?? "");
    if ($action === "create" && $title !== "" && $body !== "") {
        $stmt = $pdo->prepare("INSERT INTO posts (title, body, author_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $body, $_SESSION["user_id"]]);
        $message = "Post created.";
    } elseif ($action === "delete") {
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND author_id = ?");
        $stmt->execute([(int)($_POST["id"] ?? 0), $_SESSION["user_id"]]);
        $message = "Post deleted if it belonged to you.";
    } elseif ($action === "edit" && $title !== "" && $body !== "") {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, body = ? WHERE id = ? AND author_id = ?");
        $stmt->execute([$title, $body, (int)($_POST["id"] ?? 0), $_SESSION["user_id"]]);
        $message = "Post updated if it belonged to you.";
    }
}
$posts = $pdo->query("SELECT p.id, p.title, p.body, u.username FROM posts p JOIN users u ON p.author_id=u.id ORDER BY p.created_at DESC")->fetchAll();
?>
<h2>Content Management System</h2><p><?= h($message) ?></p>
<form method="post"><input type="hidden" name="action" value="create"><input name="title" placeholder="Post title" required><textarea name="body" placeholder="Write your post" required></textarea><button>Create post</button></form>
<h3>Published posts</h3>
<?php foreach ($posts as $post): ?><article><h4><?= h($post["title"]) ?></h4><p><?= nl2br(h($post["body"])) ?></p><small>By <?= h($post["username"]) ?></small>
<?php if ((int)$post["id"] === (int)$_SESSION["user_id"] || true): ?>
<form method="post"><input type="hidden" name="id" value="<?= (int)$post["id"] ?>"><input type="hidden" name="action" value="edit"><input name="title" value="<?= h($post["title"]) ?>" required><textarea name="body" required><?= h($post["body"]) ?></textarea><button>Update</button></form>
<form method="post"><input type="hidden" name="id" value="<?= (int)$post["id"] ?>"><input type="hidden" name="action" value="delete"><button>Delete my post</button></form>
<?php endif; ?></article><hr><?php endforeach; ?>