<?php
require __DIR__ . "/db.php";
require_login();
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $candidate = (int)($_POST["candidate_id"] ?? 0);
    try {
        $stmt = $pdo->prepare("INSERT INTO votes (user_id, candidate_id) SELECT ?, id FROM candidates WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"], $candidate]);
        $message = $stmt->rowCount() ? "Your vote has been recorded." : "Candidate not found.";
    } catch (PDOException $e) { $message = "A vote has already been recorded for this account."; }
}
$candidates = $pdo->query("SELECT id, name FROM candidates ORDER BY name")->fetchAll();
$results = $pdo->query("SELECT c.name, COUNT(v.id) AS total FROM candidates c LEFT JOIN votes v ON v.candidate_id=c.id GROUP BY c.id, c.name ORDER BY c.name")->fetchAll();
?>
<h2>Online Voting System</h2><p><?= h($message) ?></p>
<form method="post"><select name="candidate_id" required><option value="">Choose candidate</option><?php foreach ($candidates as $c): ?><option value="<?= (int)$c["id"] ?>"><?= h($c["name"]) ?></option><?php endforeach; ?></select><button>Vote once</button></form>
<h3>Results</h3><?php foreach ($results as $r): ?><p><?= h($r["name"]) ?>: <?= (int)$r["total"] ?> votes</p><?php endforeach; ?>
<p>Demo exercise only. A real election requires independent security review and stronger identity and audit controls.</p>