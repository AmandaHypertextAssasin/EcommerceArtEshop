<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? 'Πελάτης';
    $email = $_POST["email"] ?? '';
    $title = $_POST["title"] ?? '';
    $price = $_POST["price"] ?? 0.0;

    // Εισαγωγή στη βάση
    $stmt = $db->prepare("INSERT INTO orders (customer_name, customer_email, item_title, item_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $title, $price]);

    $order_id = $db->lastInsertId();
    $date = date("d/m/Y H:i");
} else {
    die("Μη έγκυρη πρόσβαση.");
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Παραστατικό #<?= $order_id ?></title>
    <link rel="stylesheet" href="css/styles.css?v=1.2">
    <style>
        .invoice {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border: 1px solid #ccc;
            font-family: sans-serif;
        }

        .invoice h2 {
            text-align: center;
        }

        .invoice table {
            width: 100%;
            margin-top: 20px;
        }

        .invoice th, .invoice td {
            padding: 10px;
            text-align: left;
        }

        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Παραστατικό Πώλησης</h2>
        <p><strong>Αρ. Παραστατικού:</strong> #<?= $order_id ?></p>
        <p><strong>Ημερομηνία:</strong> <?= $date ?></p>
        <p><strong>Πελάτης:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

        <table>
            <tr>
                <th>Περιγραφή</th>
                <th>Τιμή (€)</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($title) ?></td>
                <td><?= number_format($price, 2) ?></td>
            </tr>
        </table>

        <h3 style="text-align: right;">Σύνολο: <?= number_format($price, 2) ?> €</h3>

        <button class="print-btn" onclick="window.print()">🖨 Εκτύπωση Παραστατικού</button>
    </div>
</body>
</html>
