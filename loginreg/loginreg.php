<?php
require '../includes/koneksi.php';

$pesan_error_registrasi = '';
$pesan_success_registrasi = '';
$pesan_error_login = '';
$registration_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type'])) {
        if ($_POST['form_type'] == 'registration') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $kata_sandi = password_hash($_POST['kata_sandi'], PASSWORD_DEFAULT);

            $cek_email = "SELECT * FROM pengguna WHERE email='$email'";
            $result = $conn->query($cek_email);

            if ($result->num_rows > 0) {
                $registration_error = true;
                $pesan_error_registrasi = "The email is already registered. Please use another email.";
            } else {
                $sql = "INSERT INTO pengguna (nama, email, kata_sandi, level) VALUES ('$nama', '$email', '$kata_sandi', 1)";

                if ($conn->query($sql) === TRUE) {
                    $pesan_success_registrasi = "Registration successful! Please proceed to sign in.";
                } else {
                    $registration_error = true;
                    $pesan_error_registrasi = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } elseif ($_POST['form_type'] == 'login') {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $kata_sandi = isset($_POST['kata_sandi']) ? $_POST['kata_sandi'] : '';

            if (!empty($email) && !empty($kata_sandi)) {
                $sql = "SELECT * FROM pengguna WHERE email='$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if (password_verify($kata_sandi, $row['kata_sandi'])) {
                        session_start();
                        $_SESSION['level'] = $row['level'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['nama'] = $row['nama'];
                        $_SESSION['logged_in'] = true;
                        if ($row['level'] == 1) {
                            // Pengguna level 1 (user), redirect ke halaman index.php
                            header("Location: ../index.php");
                            exit();
                        } elseif ($row['level'] == 2) {
                            // Pengguna level 2 (tim pengontrol), redirect ke halaman pengontrol.php
                            header("Location: ../pengontrol/pengontrol.php");
                            exit();
                        } elseif ($row['level'] == 3) {
                            // Pengguna level 3 (admin), redirect ke halaman admin.php
                            header("Location: ../admin/admin.php");
                            exit();
                        } else {
                            header("Location: ../index.php");
                            exit();
                        }
                    } else {
                        $pesan_error_login = "Sign-in failed. The password you entered is incorrect.";
                    }
                } else {
                    $pesan_error_login = "Sign-in failed. The email address was not found.";
                }

            } else {
                $pesan_error_login = "Sign-in failed. Please ensure that both email and password fields are not left empty.";
            }
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="loginreg.css">
    <title>Login</title>
    <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">

    <style>
        h6.error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin: 0;
        }

        h6.success-message {
            color: green;
            font-size: 14px;
            text-align: center;
            margin: 0;
        }

        #registrasi-error-message {
            margin-top: 10px;
            text-align: center;
        }
    </style>

</head>

<body>


    <div class="container" id="container">

        <div class="form-container sign-up">
            <form action="loginreg.php" method="POST" id="formRegistrasi">
                <input type="hidden" name="form_type" value="registration">
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="nama" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="kata_sandi" required>
                <div id="registrasi-error-message" class="error-message">
                </div>
                <button type="submit" id="regis">Register</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form action="loginreg.php" method="POST" id="formLogin">
                <input type="hidden" name="form_type" value="login">
                <h1>Sign In</h1>
                <span>or use your email password</span>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="kata_sandi" required>
                <div id="login-error-message" class="error-message">
                    <?php
                    if (!empty($pesan_error_registrasi)) {
                        echo '<h6 class="alert alert-danger error-message">' . $pesan_error_registrasi . '</h6>';
                    }
                    if (!empty($pesan_success_registrasi)) {
                        echo '<h6 class="alert alert-success success-message">' . $pesan_success_registrasi . '</h6>';
                    }
                    ?>
                    <?php
                    if (!empty($pesan_error_login)) {
                        echo '<h6 class="alert alert-danger error-message">' . $pesan_error_login . '</h6>';
                    }
                    ?>
                </div>
                <button type="submit" value="Login">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <button onclick="window.location.href='../index.php'">Home
        <div class="star-1">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
        <div class="star-2">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
        <div class="star-3">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
        <div class="star-4">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
        <div class="star-5">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
        <div class="star-6">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 784.11 815.53"
                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <defs></defs>
                <g id="Layer_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                    <path
                        d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"
                        class="fil0"></path>
                </g>
            </svg>
        </div>
    </button>
    <script src="loginreg.js"></script>

</body>

</html>