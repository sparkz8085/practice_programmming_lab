<?php
require __DIR__ . "/db.php";
require_login();
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $body = trim($_POST["body"] ?? "");
    if ($body !== "" && $action === "thread") {
        $title = trim($_POST["title"] ?? "");
        if ($title !== "") {
            $stmt = $pdo->prepare("INSERT INTO threads (user_id, title, body) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION["user_id"], $title, $body]);
            $message = "Discussion created.";
        }
    } elseif ($body !== "" && $action === "reply") {
        $stmt = $pdo->prepare("INSERT INTO replies (thread_id, user_id, body) SELECT id, ?, ? FROM threads WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"], $body, (int)($_POST["thread_id"] ?? 0)]);
        $message = "Reply added.";
    }
}
$threads = $pdo->query("SELECT t.id, t.title, t.body, t.created_at, u.username FROM threads t JOIN users u ON t.user_id=u.id ORDER BY t.created_at DESC")->fetchAll();
?>
<h2>Forum / Discussion Board</h2><p><?= h($message) ?></p>
<form method="post"><input type="hidden" name="action" value="thread"><input name="title" placeholder="Discussion title" required><textarea name="body" placeholder="Start a discussion" required></textarea><button>Create thread</button></form>
<?php foreach ($threads as $thread): ?><article><h3><?= h($thread["title"]) ?></h3><p><?= nl2br(h($thread["body"])) ?></p><small>By <?= h($thread["username"]) ?> · <?= h($thread["created_at"]) ?></small>
<?php $stmt = $pdo->prepare("SELECT r.body, r.created_at, u.username FROM replies r JOIN users u ON u.id=r.user_id WHERE r.thread_id=? ORDER BY r.created_at"); $stmt->execute([$thread["id"]]); foreach ($stmt->fetchAll() as $reply): ?><blockquote><?= nl2br(h($reply["body"])) ?><small> — <?= h($reply["username"]) ?></small></blockquote><?php endforeach; ?>
<form method="post"><input type="hidden" name="action" value="reply"><input type="hidden" name="thread_id" value="<?= (int)$thread["id"] ?>"><textarea name="body" placeholder="Write a reply" required></textarea><button>Reply</button></form></article><hr><?php endforeach; ?>