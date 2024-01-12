<?php
session_start();
require("../fpdf/fpdf.php");

include '../includes/koneksi.php';

$transactionId = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : null;
$query = "SELECT id, nama_pembeli, alamat_pembeli, product, waktu_transaksi, status, total_payment, tax, quantity FROM transaksi WHERE id = '$transactionId' ORDER BY waktu_transaksi DESC LIMIT 1";
$res = $conn->query($query);


if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $transactionId = $row['id'];
    $orderDate = $row['waktu_transaksi'];
    $formattedOrderDate = substr($orderDate, 0, 10);
    $harga_database = $row["total_payment"];
    $tax_database = $row["tax"];
    $harga_tampilan = number_format($harga_database, 0, ',', '.');
    $tax_tampilan = number_format($tax_database, 0, ',', '.');
    $namaAkun = isset($_SESSION['nama_akun']) ? $_SESSION['nama_akun'] : null;

    $userQuery = "SELECT email FROM pengguna WHERE nama = '$namaAkun'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        $account = $userRow['email'];
    } else {
        $account = "Data not found";
    }
} else {
    $transactionId = "Data not found";
    $orderDate = "Data not found";
    $account = "Data not found";
}
$info = [
    "customer" => $row['nama_pembeli'],
    "address" => $row['alamat_pembeli'],
    "invoice_no" =>  $row['id'],
    "invoice_date" =>  $formattedOrderDate,
    "total_amt" =>"Rp." . $harga_tampilan,
];

$sql = "SELECT harga FROM kamera WHERE nama = '" . $row['product'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $kamera = $result->fetch_assoc();
    $harga_kamera = $kamera['harga'];
    $hargakamera_tampilan = number_format($harga_kamera, 0, ',', '.');
}

//invoice Products
$products_info = [
    [
        "name" => $row['product'],
        "price" => "Rp." . $hargakamera_tampilan,
        "qty1" => $row['quantity'],
        "qty" => "Rp." . $tax_tampilan,
        "total" => "Rp." . $harga_tampilan
    ]
];

class PDF extends FPDF
{
    function Header()
    {

        //Display Company Info
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(100, 10, "MirrageLens", 0, 1);
        $this->SetFont('Arial', '', 14);
        $this->Cell(50, 7, "Sumatera Utara,", 0, 1);
        $this->Cell(50, 7, "Medan 20239.", 0, 1);
        $this->Cell(50, 7, "Tel : 081269447678", 0, 1);

        //Display INVOICE text
        $this->SetY(20);
        $this->SetX(-40);
        $this->SetFont('Arial', 'B', 18);
        $stampLogoPath = "../assets/images/logo2.png";
        $this->Image($stampLogoPath, 210, -2, 80);
        $this->Cell(50, 40, "INVOICE", 0, 1);


        //Display Horizontal line
        $this->Line(0, 48, 300, 48);
    }

    function body($info, $products_info)
    {

        //Billing Details
        $this->SetY(55);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 10, "Bill To: ", 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, $info["customer"], 0, 1);
        $this->Cell(50, 7, $info["address"], 0, 1);

        //Display Invoice no
        $this->SetY(55);
        $this->SetX(-60);
        $this->Cell(50, 7, "Invoice Id : " . $info["invoice_no"]);

        //Display Invoice date
        $this->SetY(63);
        $this->SetX(-60);
        $this->Cell(50, 7, "Invoice Date : " . $info["invoice_date"]);

        //Display Table headings
        $this->SetY(85);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 9, "PRODUCT", 1, 0);
        $this->Cell(40, 9, "PRICE", 1, 0, "C");
        $this->Cell(20, 9, "QTY", 1, 0, "C");
        $this->Cell(50, 9, "TAX", 1, 0, "C");
        $this->Cell(60, 9, "TOTAL", 1, 1, "C");
        $this->SetFont('Arial', '', 12);

        //Display table product rows
        foreach ($products_info as $row) {
            $this->Cell(100, 9, $row["name"], "LR", 0);
            $this->Cell(40, 9, $row["price"], "R", 0, "R");
            $this->Cell(20, 9, $row["qty1"], "R", 0, "C");
            $this->Cell(50, 9, $row["qty"], "R", 0, "R");
            $this->Cell(60, 9, $row["total"], "R", 1, "R");
        }

        //Display table total row
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(210, 9, "TOTAL", 1, 0, "R");
        $this->Cell(60, 9, $info["total_amt"], 1, 1, "R");

        //Display amount in words
        $this->SetY(125);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 9, "Thanks for shopping.!", 0, 1);
        $this->SetFont('Arial', '', 12);

    }
    function Footer()
    {

        //set footer position
        $this->SetY(-50);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, "MirrageLens", 0, 1, "R");
        $this->Ln(22);
        $stampImagePath = "../assets/images/stamp.png";
        $this->Image($stampImagePath, 260, 167, 27);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, "Authorized Signature", 0, 1, "R");
        $this->SetFont('Arial', '', 10);

        //Display Footer Text
        $this->Cell(0, 10, "This is a computer generated invoice", 0, 1, "C");

    }

}
//Create A4 Page with Portrait 
$pdf = new PDF("L", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
?>