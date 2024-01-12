<?php

session_start();

if (!isset($_SESSION['level'])) {
  header("Location: ../error.php");
  exit();
}

if ($_SESSION['level'] != 3) {
  header("Location: ../error.php");
  exit();
}

include "../includes/koneksi.php";

$query = "SELECT * FROM contactus";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengontrol</title>
  <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #efebe8;
    }

    .card {
      background-color: #f9f9f8;
      margin-top: 20px;
    }

    .mx-auto {
      width: 800px;
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
    }

    .btn-action {
      margin-right: 5px;
    }

    .table-striped {
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <button class="Btnn" onclick="goBack()">
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
        Contact Us
      </h5>
      <div class="card-body">
        <table id="example" class="table table-striped" style="width:100%">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Message</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['telepon'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['komentar'] . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#example').DataTable();
    });
    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>