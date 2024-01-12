<?php
session_start();
include '../includes/koneksi.php';

if (isset($_POST['payButton'])) {
    // Get form data
    $nama_pembeli = $_POST['nama'];
    $alamat_pembeli = $_POST['alamat'];
    $namaAkun = $_SESSION['email'];
    $totalPayment = $_POST['total_payment'];
    $quantity = $_POST['quantities'];
    $tax = $_POST['tax_value'];
    $productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;

    $productQuery = "SELECT nama, harga, foto FROM kamera WHERE id = $productId";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $row = $productResult->fetch_assoc();
        $product_name = $row["nama"];

        $sql = "INSERT INTO transaksi (nama_akun, nama_pembeli, alamat_pembeli, product, total_payment, tax, quantity) VALUES ('$namaAkun', '$nama_pembeli', '$alamat_pembeli', '$product_name', '$totalPayment', '$tax', '$quantity')";

        if ($conn->query($sql) === TRUE) {
            $transactionId = $conn->insert_id;

            header("Location: paymentsuccess.php?transaction_id={$transactionId}");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
}

$conn->close();
?>
