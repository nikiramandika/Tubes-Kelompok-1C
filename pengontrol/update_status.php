<?php
include '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transactionId'];
    $newStatus = $_POST['newStatus'];
    $updateQuery = "UPDATE transaksi SET status = $newStatus WHERE id = $transactionId";
    $conn->query($updateQuery);

    echo "Status updated successfully.";
} else {
    echo "Invalid request.";
}

$conn->close();
?>
