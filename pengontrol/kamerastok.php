<?php

session_start();

if (($_SESSION['level']) == 1) {
    header("Location: ../error.php");
    exit();
}

include "../includes/koneksi.php";

$nama = "";
$harga = "";
$stok = "";
$tahun = "";
$foto = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
$foto = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $harga_database = str_replace('.', '', $harga);
    $harga_tampilan = number_format($harga_database, 0, ',', '.');
    $stok = $_POST['stok'];
    $tahun = $_POST['tahun'];

    if (!empty($_FILES["fileToUpload"]["name"])) {
        $foto = $_FILES["fileToUpload"]["name"];
        $targetDirectory = "../assets/images/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "<div class='alert alert-success' role='alert'>
            Gambar Berhasil diunggah!
          </div>";
            echo "<script>
          setTimeout(function() {
              window.location.href = 'kamerastok.php';
          }, 3000);
        </script>";
        } else {
            echo "Terjadi kesalahan saat mengunggah gambar.";
            echo "<script>
            setTimeout(function() {
                window.location.href = 'kamerastok.php';
            }, 3000);
          </script>";
        }
    } else {
        $foto = $_POST['fileToUpload'];
    }

    if ($op == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $updateQuery = "UPDATE kamera SET nama='$nama', harga='$harga_database', stok='$stok', tahun='$tahun', foto='$foto' WHERE id=$id";

            $conn->query($updateQuery);

            echo "<div class='alert alert-success' role='alert'>
            Data berhasil diupdate!
          </div>";

            echo "<script>
            setTimeout(function() {
                window.location.href = 'kamerastok.php';
            }, 3000);
          </script>";
        }
    } else {
        $insertQuery = "INSERT INTO kamera (nama, harga, stok, tahun, foto) VALUES ('$nama', '$harga_database', '$stok', '$tahun', '$foto')";
        $conn->query($insertQuery);

        echo "<div class='alert alert-success' role='alert'>
        Data berhasil ditambahkan!
      </div>";

        echo "<script>
        setTimeout(function() {
            window.location.href = 'kamerastok.php';
        }, 3000);
      </script>";
    }
}


if ($op == 'edit') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM kamera WHERE id = $id";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row) {
                $nama = $row['nama'];
                $harga = $row['harga'];
                $stok = $row['stok'];
                $tahun = $row['tahun'];
                $foto = $row['foto'];
            } else {
            }
        } else {
        }
    } else {
    }
} else {
}

if (isset($_GET['op']) && $_GET['op'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    $deleteQuery = "DELETE FROM kamera WHERE id = $id_to_delete";
    $conn->query($deleteQuery);

    echo "<div class='alert alert-warning' role='alert'>
    Data berhasil dihapus!
  </div>";

    echo "<script>
    setTimeout(function() {
        window.location.href = 'kamerastok.php';
    }, 3000);
  </script>";
}

$query = "SELECT * FROM kamera"; 
$result = $conn->query($query);
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
        body {
            background-color: #efebe8;
        }

        .card {
            background-color: #f9f9f8;
            margin-top: 20px;
        }

        .mx-auto {
            width: 900px;
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
                Create & Update Data
            </h5>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="harga" name="harga"
                                value="<?php echo $harga; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="stok" class="col-sm-2 col-form-label">stok</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="stok" name="stok"
                                value="<?php echo $stok; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun" class="col-sm-2 col-form-label">tahun</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="tahun" name="tahun"
                                value="<?php echo $tahun; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">foto</label>
                        <div class="col-sm-7">
                            <?php if (!empty($foto)) { ?>
                                <input type="hidden" name="fileToUpload" value="<?php echo $foto; ?>">
                                <p>File yang ada:
                                    <?php echo $foto; ?>
                                </p>
                            <?php } else { ?>
                                <input type="file" class="form-control" id="foto" name="fileToUpload">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mx-auto">
        <div class="card">
            <h5 class="card-header">
                List Camera
            </h5>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>harga</th>
                            <th>stok</th>
                            <th>tahun</th>
                            <th>foto</th>
                            <th colspan="2">Action</th>
                            <th style="display : none;">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Tampilkan data dalam tabel
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $harga_database = $row["harga"];
                                $harga_tampilan = number_format($harga_database, 0, ',', '.');
                                echo "<tr>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $harga_tampilan . "</td>";
                                echo "<td>" . $row['stok'] . "</td>";
                                echo "<td>" . $row['tahun'] . "</td>";
                                echo "<td>" . $row['foto'] . "</td>";
                                echo "<td>
                                        <a href='kamerastok.php?op=edit&id=" . $row['id'] . "' class='btn btn-warning btn-action'>Edit</a>
                                        </td>";
                                echo "<td>
                                        <a href='kamerastok.php?op=delete&id=" . $row['id'] . "' class='btn btn-danger btn-action' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data?\")'>Delete</a>
                                        </td>";
                                echo "<td style='display : none;'>
                                        </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Tidak ada data</td></tr>"; // Perbaikan pada jumlah kolom di sini
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
            // Fungsi ini akan dipanggil setiap kali nilai input berubah
            $("#harga").on("input", function () {
                // Ambil nilai dari input
                var inputValue = $(this).val();

                // Hapus semua karakter selain angka
                inputValue = inputValue.replace(/[^0-9]/g, '');

                // Format angka menjadi 20.000
                var formattedValue = new Intl.NumberFormat('id-ID').format(inputValue);

                // Set nilai input dengan format yang diinginkan
                $(this).val(formattedValue);
            });
        });
        function goBackHome() {
            window.location.href = 'pengontrol.php';
        }
    </script>
</body>

</html>