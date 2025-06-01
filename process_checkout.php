<?php
// process checkout.php
//PHP που χειρίζεται το POST 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $items = $_POST['items']; // JSON array
    $total = $_POST['total'];

    $db = new PDO('sqlite:db/database.sqlite');
    $stmt = $db->prepare("INSERT INTO orders (customer_name, customer_email, items, total) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $items, $total]);

    $order_id = $db->lastInsertId();

    // Στείλε παραστατικό
    $cmd = shell_exec("curl -X POST -H 'Content-Type: application/json' -d '{\"order_id\":$order_id}' http://localhost/api/send_invoice.php");

    echo "Η παραγγελία καταχωρήθηκε και το παραστατικό στάλθηκε!";
}