<?php
// api/get_artworks.php
$db = new PDO('sqlite:../db/database.sqlite');
$stmt = $db->query("SELECT * FROM artworks");
$artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($artworks);
?>