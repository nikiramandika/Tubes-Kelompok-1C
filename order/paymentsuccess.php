<?php
session_start();
include '../includes/koneksi.php';


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../loginreg/loginreg.php");
    exit();
}

$transactionId = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : null;
$query = "SELECT id, alamat_pembeli, product, waktu_transaksi, status FROM transaksi WHERE id = '$transactionId' ORDER BY waktu_transaksi DESC LIMIT 1";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $transactionId = $row['id'];
    $orderDate = $row['waktu_transaksi'];
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
            return "Requsted to Canceled";
        default:
            return "Unknown";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MirrageLens - Buy your favourite Camera</title>

    <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="paymentsuccess.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Open+Sans&display=swap"
        rel="stylesheet">

    <style>
        p[status="0"],
        [status="3"] {
            color: #464646;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 22px;
            margin: 0;
        }

        p[status="1"] {
            color: red;
            font-weight: bold;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 22px;
            margin: 0;
        }

        p[status="2"] {
            color: green;
            font-weight: bold;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 22px;
            margin: 0;
        }
    </style>

</head>

<body>

    <header class="header" data-header>
        <div class="container">

            <div class="overlay" data-overlay></div>

            <a href="../index.php" class="logo">
                <img src="../assets/images/logo2.png" alt="logo" width="200px">
            </a>

            <?php

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                echo '<nav class="navbar" data-navbar>
        <ul class="navbar-list">
            <li>
                <a href="../index.php" class="navbar-link" data-nav-link>Home</a>
            </li>
            <li>
                <a href="../index.php" class="navbar-link" data-nav-link>Camera</a>
            </li>
            <li>
                <a href="../index.php" class="navbar-link" data-nav-link>About us</a>
            </li>
            <li>
                <a href="history.php" class="navbar-link" data-nav-link>Order</a>
            </li>
        </ul>
    </nav>';
            } else {
                echo '<nav class="navbar" data-navbar>
        <ul class="navbar-list">
            <li>
                <a href="#home" class="navbar-link" data-nav-link>Home</a>
            </li>
            <li>
            <a href="#featured-car" class="navbar-link" data-nav-link>Explore camera</a>
            </li>
            <li>
            <a href="#footer" class="navbar-link" data-nav-link>About us</a>
            </li>
            </ul>
            </nav>';
            }
            ?>


            <div class="header-actions">
                <?php

                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                    // User is logged in
                    echo "Halo! " . $_SESSION['nama'];
                    echo '<button class="Btnnn" data-toggle="modal" data-target="#exampleModal">
          <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
          <div class="text">Logout</div>
          </button>';
                } else {
                    // User is not logged in
                    echo '<a href="#featured-car" class="btn" aria-labelledby="aria-label-txt">
          <ion-icon name="camera-outline"></ion-icon>
          <span id="aria-label-txt">Explore camera</span>
          </a>';
                    echo '<a href="loginreg/loginreg.php" class="btn user-btn" aria-label="Login">
          <ion-icon name="person-outline"></ion-icon>
          </a>';
                }
                ?>
                <div class="sub-menu-wrap">
                    <div class="sub-menu">
                        <div class="user-info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn1 btn-danger" onclick="goToLogout()">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <main>
        <center>

            <div class="paymentsuccess">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" cols="1" style="max-width: 600px; width: 100%;">
                            <tr>
                                <td height="30">
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" cols="3" class="bordered-left-right">
                            <tr height="50">
                                <td colspan="3">
                                </td>
                            </tr>
                            <tr align="center">
                                <td width="36">
                                </td>
                                <td class="text-primary"
                                    style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    <img src="http://dgtlmrktng.s3.amazonaws.com/go/emails/generic-email-template/tick.png"
                                        alt="GO" width="50"
                                        style="border: 0; font-size: 0; margin: 0; max-width: 100%; padding: 0;">
                                </td>
                                <td width="36">
                                </td>
                            </tr>
                            <tr height="17">
                                <td colspan="3">
                                </td>
                            </tr>
                            <tr align="center">
                                <td width="36">
                                </td>
                                <td class="text-primary"
                                    style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    <h1
                                        style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 34px; margin-bottom: 0; margin-top: 0;">
                                        Payment received</h1>
                                </td>
                                <td width="36">
                                </td>
                            </tr>
                            <tr height="30">
                                <td colspan="3">
                                </td>
                            </tr>
                            <tr align="left">
                                <td width="36">
                                </td>
                                <td>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        <?php echo "Halo! " . $_SESSION['nama']; ?>,
                                    </p>
                                </td>
                                <td width="36">
                                </td>
                            </tr>
                            <tr height="10">
                                <td colspan="3">
                                </td>
                            </tr>
                            <tr align="left">
                                <td width="36">
                                </td>
                                <td>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        Your transaction was successful!</p>
                                    <br>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        <b>Product:</b><br>
                                        <?php echo $row['product']; ?>
                                    </p>
                                    <br>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0; ">
                                        <strong>Payment Details:</strong><br />

                                        Address :
                                        <?php echo $row['alamat_pembeli']; ?> <br />
                                        Account :
                                        <?php echo $_SESSION['email']; ?><br />
                                        Method :
                                        Cash On Delivery<br />

                                    </p>
                                    <br>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        We advise to keep this email for future reference.&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                        <b>Status :</b>
                                    </p>
                                    <p status='<?php echo $row['status']; ?>'>
                                        <?php echo getStatusLabel($row['status']); ?>
                                    </p> <br />

                                    <a href="Invoice.php?transaction_id=<?php echo $row['id']; ?>" target="_blank"
                                        class="btn btn-primary">View Invoice</a>

                                </td>

                            </tr>
                            <tr height="30">
                                <td>
                                </td>
                                <td
                                    style="border-bottom: 1px solid #D3D1D1; color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr height="30">
                                <td colspan="3">
                                </td>
                            </tr>
                            <tr align="center">
                                <td width="36">
                                </td>
                                <td>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        <strong>Transaction id:
                                            <?php echo $row['id'] ?>
                                        </strong>
                                    </p>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                        Order date:
                                        <?php echo $row['waktu_transaksi'] ?>
                                    </p>
                                    <p
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                    </p>
                                </td>
                                <td width="36">
                                </td>
                            </tr>

                            <tr height="50">
                                <td colspan="3">
                                </td>
                            </tr>

                        </table>
                        <table cellpadding="0" cellspacing="0" cols="1" align="center"
                            style="max-width: 600px; width: 100%;">
                            <tr>
                                <td height="50">
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </div>
        </center>
    </main>


    <footer class="footer" id="footer">
        <div class="container">

            <div class="footer-top">

                <div class="footer-brand">
                    <a href="#" class="logo">
                        <img src="../assets/images/logotulisan.png" alt="logo" width="220px">
                    </a>

                    <p class="footer-text">
                        Find affordable cameras in Medan. With a diverse inventory any products, MirrageLens offers its
                        customers an attractive and enjoyable selection.
                    </p>
                </div>

                <ul class="footer-list">

                    <li>
                        <p class="footer-list-title">Category</p>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Home</a>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Camera</a>
                    </li>

                    <li>
                        <a href="#" class="footer-link">About Us</a>
                    </li>

                </ul>

                <ul class="footer-list">

                    <li>
                        <p class="footer-list-title">Contact</p>
                    </li>

                    <li>
                        <a href="../contactus.php" class="footer-link">Help Center</a>
                    </li>

                    <li>
                        <a href="../contactus.php" class="footer-link">Ask a Question</a>
                    </li>

                    <li>
                        <a>Pemrograman Web</a>
                    </li>
                    <li>
                        <a>Kelompok 1</a>
                    </li>

                </ul>


            </div>

            <div class="footer-bottom">

                <ul class="social-list">

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-instagram"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-twitter"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-linkedin"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-skype"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="mail-outline"></ion-icon>
                        </a>
                    </li>

                </ul>

                <p class="copyright">
                    &copy; 2023 <a href="#">MirrageLens</a>. All Rights Reserved
                </p>

            </div>

        </div>
    </footer>

    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        function goToLogin() {
            window.location.href = 'loginreg/loginreg.php'
        }
        function goToLogout() {
            window.location.href = '../loginreg/logout.php'
        }
        function goToOrder() {
            window.location.href = 'order/order.php'
        }
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>