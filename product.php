<?php
include 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
?>
<h1><?= $product['name'] ?></h1>
<img src="images/<?= $product['image'] ?>" width="200">
<p><?= $product['description'] ?></p>
<p>Price: $<?= $product['price'] ?></p>
