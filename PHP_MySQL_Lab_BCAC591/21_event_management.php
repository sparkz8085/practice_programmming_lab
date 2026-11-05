<?php
require __DIR__ . "/db.php";
require_login();
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventId = (int)($_POST["event_id"] ?? 0);
    try {
        $stmt = $pdo->prepare("INSERT INTO event_registrations (event_id, user_id) SELECT id, ? FROM events WHERE id = ? AND event_date >= NOW()");
        $stmt->execute([$_SESSION["user_id"], $eventId]);
        $message = $stmt->rowCount() ? "Registration successful." : "Event unavailable or already registered.";
    } catch (PDOException $e) { $message = "You are already registered for this event."; }
}
$events = $pdo->query("SELECT e.id, e.title, e.event_date, e.description, COUNT(r.id) AS participants FROM events e LEFT JOIN event_registrations r ON r.event_id=e.id GROUP BY e.id ORDER BY e.event_date")->fetchAll();
?>
<h2>Event Management System</h2><p><?= h($message) ?></p>
<?php foreach ($events as $event): ?><article><h3><?= h($event["title"]) ?></h3><p><?= h($event["event_date"]) ?></p><p><?= nl2br(h($event["description"] ?? "")) ?></p><p>Participants: <?= (int)$event["participants"] ?></p><form method="post"><input type="hidden" name="event_id" value="<?= (int)$event["id"] ?>"><button>Register</button></form></article><hr><?php endforeach; ?>