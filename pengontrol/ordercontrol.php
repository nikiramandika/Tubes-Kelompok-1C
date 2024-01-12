<?php
session_start();
include '../includes/koneksi.php';

$namaAkun = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transactionId'];
    $newStatus = $_POST['newStatus'];

    $updateQuery = "UPDATE transaksi SET status = $newStatus WHERE id = $transactionId";
    $conn->query($updateQuery);

    echo "<div class='alert alert-success' role='alert'>
    Transaksi Berhasil diupdate!
  </div>";
    echo "<script>
  setTimeout(function() {
      window.location.href = 'ordercontrol.php';
  }, 3000);
</script>";


}

function getStatusLabel($status)
{
    switch ($status) {
        case 0:
            return "Process";
        case 1:
            return "Cancelled";
        case 2:
            return "Complete";
        case 3:
            return "Requested to Cancel";
        default:
            return "Unknown";
    }
}
$historyQuery = "SELECT * FROM transaksi";
$historyResult = $conn->query($historyQuery);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data user</title>
    <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .alert {}

        body {
            background-color: #f8f9fa;
        }

        .mx-auto {
            width: 1200px;
        }

        #example {
            width: 100%;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .card {
            margin-top: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            margin-bottom: -15px;
            overflow-x: auto;
        }

        #example {
            width: 100%;
            max-width: 100%;
        }


        .btn-action {
            margin-right: 5px;
        }

        body {
            background-color: #efebe8;
        }

        .card {
            background-color: #f9f9f8
        }

        select,
        option {
            border-radius: 6px;
            padding: 5px;
            background-color: #f9f9f8;
            color: black;
        }
    </style>
</head>

<body>
    <button class="Btnn" onclick="goBackHome()">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Back</span>
    </button>

    <div class="mx-auto">
        <div class="card">
            <h5 class="card-header">
                List Transaction
            </h5>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Product </th>
                            <th>Buyer's </th>
                            <th>Email's </th>
                            <th>Address</th>
                            <th>Time Transaction</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Tampilkan data dalam tabel
                        if ($historyResult && $historyResult->num_rows > 0) {
                            while ($row = $historyResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['product'] . "</td>";
                                echo "<td>" . $row['nama_pembeli'] . "</td>";
                                echo "<td>" . $row['nama_akun'] . "</td>";
                                echo "<td>" . $row['alamat_pembeli'] . "</td>";
                                echo "<td>" . date('d F Y H:i:s', strtotime($row['waktu_transaksi'])) . "</td>";
                                echo "<td>";
                                echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
                                echo "<input type='hidden' name='transactionId' value='" . $row['id'] . "'>";
                                echo "<select name='newStatus'>";
                                echo "<option value='0' " . ($row['status'] == 0 ? 'selected' : '') . ">Process</option>";
                                echo "<option value='1' " . ($row['status'] == 1 ? 'selected' : '') . ">Cancelled</option>";
                                echo "<option value='2' " . ($row['status'] == 2 ? 'selected' : '') . ">Complete</option>";
                                echo "</select>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input class='btn btn-primary btn-action' type='submit' value='Update'>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No transaction history found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="mx-auto">
    <div class="card">
        <h5 class="card-header">
            List Transaction request to cancel.
        </h5>
        <div class="card-body">
            <table id="example-status3" class="table table-striped" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Buyer's</th>
                        <th>Email's</th>
                        <th>Address</th>
                        <th>Time Transaction</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $historyQueryStatus3 = "SELECT * FROM transaksi WHERE status = 3";
                    $historyResultStatus3 = $conn->query($historyQueryStatus3);

                    if ($historyResultStatus3 && $historyResultStatus3->num_rows > 0) {
                        while ($rowStatus3 = $historyResultStatus3->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowStatus3['id'] . "</td>";
                            echo "<td>" . $rowStatus3['product'] . "</td>";
                            echo "<td>" . $rowStatus3['nama_pembeli'] . "</td>";
                            echo "<td>" . $rowStatus3['nama_akun'] . "</td>";
                            echo "<td>" . $rowStatus3['alamat_pembeli'] . "</td>";
                            echo "<td>" . date('d F Y H:i:s', strtotime($rowStatus3['waktu_transaksi'])) . "</td>";
                            echo "<td>" . getStatusLabel($rowStatus3['status']) . "</td>";
                            echo "<td>";
                            // Accept button
                            echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
                            echo "<input type='hidden' name='transactionId' value='" . $rowStatus3['id'] . "'>";
                            echo "<input type='hidden' name='newStatus' value='1'>";
                            echo "<input class='btn btn-success btn-action' type='submit' value='Accept'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No transaction request to cancel.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
        $(document).ready(function () {
            $("#harga").on("input", function () {
                var inputValue = $(this).val();

                inputValue = inputValue.replace(/[^0-9]/g, '');

                var formattedValue = new Intl.NumberFormat('id-ID').format(inputValue);

                $(this).val(formattedValue);
            });
        });
        function goBackHome() {
            window.location.href = 'pengontrol.php';
        }
    </script>
</body>

</html>