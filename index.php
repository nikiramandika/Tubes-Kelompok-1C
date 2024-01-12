<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MirrageLens - Buy your favourite Camera</title>
  <link rel="shortcut icon" href="./photo-camera-svgrepo-com.svg" type="image/svg+xml">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Open+Sans&display=swap"
    rel="stylesheet">
  <style>


  </style>
</head>

<body>
  <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="index.php" class="logo">
        <img src="./assets/images/logo2.png" alt="logo" width="200px">
      </a>

      <?php
      session_start();
      include 'includes/koneksi.php';

      if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<nav class="navbar" data-navbar>
        <ul class="navbar-list">
            <li>
                <a href="#home" class="navbar-link" data-nav-link><b>Home</b></a>
            </li>
            <li>
                <a href="#featured-car" class="navbar-link" data-nav-link>Camera</a>
            </li>
            <li>
            <a href="#footer" class="navbar-link" data-nav-link>About us</a>
            </li>
            <li>
                <a href="order/history.php" class="navbar-link" data-nav-link>Order</a>
            </li>
        </ul>
    </nav>';
      } else {
        echo '<nav class="navbar" data-navbar>
        <ul class="navbar-list">
            <li>
                <a href="#home" class="navbar-link" data-nav-link><b>Home</b></a>
            </li>
            <li>
                <a href="#featured-car" class="navbar-link" data-nav-link>Camera</a>
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
          <div class="text" >Logout</div>
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
    <article>
      <section class="section hero" id="home">
        <div class="container">

          <div class="hero-content">
            <h2 class="h1 hero-title">Capture. Picture. <b>Save the Moment.</b></h2>

            <p class="hero-text">
              <b>Kelompok </b>1
            </p>
          </div>

          <div class="hero-banner"></div>



        </div>
      </section>

      <?php
      include 'includes/koneksi.php';
      if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<section class="section featured-car" id="featured-car">
      <div class="container">
        <div class="title-wrapper">
          <h2 class="h2 section-title">Camera</h2>

          <a href="users/listcamera.php" class="featured-car-link">
            <span>View more</span>

            <ion-icon name="arrow-forward-outline"></ion-icon>
          </a>
        </div>

        <ul class="featured-car-list">';

        $sql = "SELECT id, nama, harga, foto, tahun, stok FROM kamera";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $count = 0;
          while ($count < 6 && $row = $result->fetch_assoc()) {
            $harga_database = $row["harga"];
            $harga_tampilan = number_format($harga_database, 0, ',', '.');

            echo "<li>
              <div class='featured-car-card'>
                <figure class='card-banner'>
                  <img src='assets/images/" . $row["foto"] . "'  loading='lazy' width='440' height='300' class='w-100'>
                </figure>
                <div class='card-content'>
                  <div class='card-title-wrapper'>
                    <h3 class='h3 card-title'>
                      <a href='#'>" . $row["nama"] . "</a>
                    </h3>
                    <data class='year' value='2021'>" . $row["tahun"] . "</data>
                  </div>
                  <ul class='card-list'>
                  <li class='card-list-item'>
                    <span class='card-item-text'><b>Available : </b>" . $row["stok"] . "</span>
                  </li>
                </ul>
                  <div class='card-price-wrapper'>
                    <p class='card-price'>
                      <strong>Rp." . $harga_tampilan . "</strong>
                    </p>
                    <button class='btn' onclick='buyNow(\"" . $row["id"] . "\")'>Buy Now</button>
                  </div>
                </div>
              </div>
            </li>";
            $count++;
          }
        } else {
          echo "<li>Tidak ada data kamera.</li>";
        }

        echo '</ul>
      </div>
    </section>';
      } else {
        echo '<section class="section featured-car" id="featured-car">
        <div class="container">
          <div class="title-wrapper">
            <h2 class="h2 section-title">Camera</h2>
  
            <a href="loginreg/loginreg.php" class="featured-car-link">
              <span>View more</span>
  
              <ion-icon name="arrow-forward-outline"></ion-icon>
            </a>
          </div>
  
          <ul class="featured-car-list">';

        $sql = "SELECT id, nama, harga, foto, tahun, stok FROM kamera";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $count = 0;
          while ($count < 6 && $row = $result->fetch_assoc()) {
            $harga_database = $row["harga"];
            $harga_tampilan = number_format($harga_database, 0, ',', '.');
            echo "<li>
              <div class='featured-car-card'>
                <figure class='card-banner'>
                  <img src='assets/images/" . $row["foto"] . "'  loading='lazy' width='440' height='300' class='w-100'>
                </figure>
                <div class='card-content'>
                  <div class='card-title-wrapper'>
                    <h3 class='h3 card-title'>
                      <a href='#'>" . $row["nama"] . "</a>
                    </h3>
                    <data class='year' value='2021'>" . $row["tahun"] . "</data>
                  </div>
                  <ul class='card-list'>
                  <li class='card-list-item'>
                    <span class='card-item-text'><b>Available : </b>" . $row["stok"] . "</span>
                  </li>
                </ul>
                  <div class='card-price-wrapper'>
                    <p class='card-price'>
                      <strong>Rp." . $harga_tampilan . "</strong>
                    </p>
                    <button class='btn' onclick='goToLogin()'>Buy Now</button>
                  </div>
                </div>
              </div>
            </li>";
            $count++;
          }
        } else {
          echo "<li>Tidak ada data kamera.</li>";
        }

        echo '</ul>
        </div>
      </section>';
      }
      ?>

    </article>
  </main>

  <footer class="footer" id="footer">
    <div class="container">

      <div class="footer-top">

        <div class="footer-brand">
          <a href="#" class="logo">
            <img src="./assets/images/logotulisan.png" alt="logo" width="220px">
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
          <?php
          if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<li>
            <p class="footer-list-title">Contact</p>
          </li>

          <li>
            <a href="contactus.php" class="footer-link">Help Center</a>
          </li>
          
          <li>
            <a href="contactus.php" class="footer-link">Ask a Question</a>
          </li>
          
          <li>
            <a>Pemrograman Web</a>
          </li>
          <li>
            <a>Kelompok 1</a>
          </li>';
          } else {
            echo '<li>
        <p class="footer-list-title">Contact</p>
      </li>

      <li>
        <a href="loginreg/loginreg.php" class="footer-link">Help Center</a>
      </li>
      
      <li>
        <a href="loginreg/loginreg.php" class="footer-link">Ask a Question</a>
      </li>
      
      <li>
        <a>Pemrograman Web</a>
      </li>
      <li>
        <a>Kelompok 1</a>
      </li>';
          }

          ?>

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
    const header = document.querySelector('.header');

    function toggleHeaderShadow() {
      if (window.scrollY > 0) {
        header.classList.add('header-scrolled');
      } else {
        header.classList.remove('header-scrolled');
      }
    }

    window.addEventListener('scroll', toggleHeaderShadow);
  </script>

  <script>
    function buyNow(productId) {
      window.location.href = `order/index.php?product_id=${productId}`;
    }

    function goToLogin() {
      window.location.href = 'loginreg/loginreg.php'
    }
    function goToLogout() {
      window.location.href = 'loginreg/logout.php'
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