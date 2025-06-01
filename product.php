<?php
include 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM artworks WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
?>
<h1><?= htmlspecialchars($product['title']) ?></h1>
<img src="img/artworks/<?= htmlspecialchars($product['image']) ?>" width="200">
<p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
<p>Τιμή: €<?= number_format($product['price'], 2) ?></p>
