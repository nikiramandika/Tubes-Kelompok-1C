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

$nama = "";
$email = "";
$level = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level = $_POST['level'];

    if ($op == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $updateQuery = "UPDATE pengguna SET level='$level' WHERE id=$id";
            $conn->query($updateQuery);

            echo "<div class='alert alert-success' role='alert'>
                    Data berhasil diupdate!
                  </div>";

            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'datauser.php';
                    }, 3000);
                  </script>";

        }

    } else {
        echo "<div class='alert alert-warning' role='alert'>
        Tidak bisa menambahkan data!
      </div>";

        echo "<script>
      setTimeout(function() {
          window.location.href = 'datauser.php';
      }, 3000);
    </script>";
    }
}

if ($op == 'edit') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM pengguna WHERE id = $id";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row) {
                $nama = $row['nama'];
                $email = $row['email'];
                $level = $row['level'];
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
    $deleteQuery = "DELETE FROM pengguna WHERE id = $id_to_delete";
    $conn->query($deleteQuery);

    echo "<div class='alert alert-warning' role='alert'>
                Data berhasil dihapus!
              </div>";

    echo "<script>
                setTimeout(function() {
                    window.location.href = 'datauser.php';
                }, 3000);
              </script>";
}


$query = "SELECT * FROM pengguna WHERE level IN (1,2)"; 
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
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #efebe8;
        }

        .mx-auto {
            width: 800px;
        }

        .card {}

        #example {
            width: 100%;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .card {
            background-color: #f9f9f8;
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
                Update Data
            </h5>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input disabled type="text" class="form-control" id="nama" name="unama"
                                value="<?php echo $nama; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input disabled type="text" class="form-control" id="email" name="eemail"
                                value="<?php echo $email; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                        <div class="col-sm-10">
                            <input type="number" min="1" max="2" class="form-control" id="level" name="level"
                                value="<?php echo $level; ?>">
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
                Data Users
            </h5>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['level'] . "</td>";
                                echo "<td>
                                        <a href='datauser.php?op=edit&id=" . $row['id'] . "' class='btn btn-warning btn-action'>Edit</a>
                                        <a href='datauser.php?op=delete&id=" . $row['id'] . "' class='btn btn-danger btn-action' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data user?\")'>Delete</a>
                                      </td>";
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
        function goBackHome() {
            window.location.href = 'admin.php';
        }


    </script>
</body>

</html>