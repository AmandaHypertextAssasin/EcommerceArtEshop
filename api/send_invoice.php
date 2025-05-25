<?php
// api/send_invoice.php
$data = json_decode(file_get_contents("php://input"), true);

// Έλεγχος στοιχείων
if (!isset($data['order_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing order ID"]);
    exit;
}

// Ανάκτηση από SQLite
$db = new PDO('sqlite:../db/database.sqlite');
$stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$data['order_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(404);
    echo json_encode(["error" => "Order not found"]);
    exit;
}

// Δημιουργία παραστατικού
$invoice = [
    "customer" => [
        "name" => $order['customer_name'],
        "email" => $order['customer_email']
    ],
    "items" => json_decode($order['items']),
    "total" => $order['total'],
    "date" => $order['created_at']
];

// Αποστολή στο API του παρόχου
$ch = curl_init("https://api.provider.gr/invoices");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoice));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer YOUR_API_TOKEN'
]);
$response = curl_exec($ch);
curl_close($ch);

// Αποτέλεσμα
echo $response;