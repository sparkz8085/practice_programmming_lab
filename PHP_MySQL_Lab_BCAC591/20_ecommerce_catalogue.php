<?php
require __DIR__ . "/db.php";
$search = trim($_GET["q"] ?? "");
$category = trim($_GET["category"] ?? "");
$sql = "SELECT id, name, category, description, price FROM products WHERE 1=1";
$params = [];
if ($search !== "") { $sql .= " AND (name LIKE ? OR description LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }
if ($category !== "") { $sql .= " AND category = ?"; $params[] = $category; }
$sql .= " ORDER BY category, name";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<h2>E-commerce Product Catalogue</h2>
<form method="get"><input name="q" value="<?= h($search) ?>" placeholder="Search products"><select name="category"><option value="">All categories</option><?php foreach ($categories as $c): ?><option value="<?= h($c) ?>" <?= $category === $c ? "selected" : "" ?>><?= h($c) ?></option><?php endforeach; ?></select><button>Search</button></form>
<?php foreach ($products as $p): ?><article><h3><?= h($p["name"]) ?></h3><p><?= h($p["category"]) ?> | ₹<?= number_format((float)$p["price"], 2) ?></p><p><?= nl2br(h($p["description"] ?? "")) ?></p></article><?php endforeach; ?>
<?php if (!$products): ?><p>No products found.</p><?php endif; ?>