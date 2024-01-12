<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MirrageLens - Buy your favourite Camera</title>
  <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="listkamera.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Open+Sans&display=swap"
    rel="stylesheet">
  <style>
    .card-title-wrapper {
      margin-bottom: 13px;
    }

    .card-title-wrapper {
      padding-top: 10px;
    }

    .header.scrolled {
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>
      <button class="Btnn" onclick="goBack()">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
          <path
            d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
          </path>
        </svg>
        <span>Back</span>
      </button>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li>
            <h1>Camera List</h1>
          </li>


        </ul>
      </nav>

      <div class="header-actions">

      </div>

    </div>
  </header>


  <main>
    <article>

      <section class="section featured-car" id="featured-car">
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title">Camera</h2>
            <h3 class="h3 section-title">Sony Camera</h3>

          </div>

          <ul class="featured-car-list">
            <?php
            include '../includes/koneksi.php';

            $sql = "SELECT id, nama, harga, foto, tahun, stok FROM kamera";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {

                $harga_database = $row["harga"];
                $harga_tampilan = number_format($harga_database, 0, ',', '.');

                echo "<li>
            <div class='featured-car-card' data-product-id='" . $row["id"] . "'>
                <figure class='card-banner'>
                    <img src='../assets/images/" . $row["foto"] . "' alt='Sony Alpha A1' loading='lazy' width='440' height='300' class='w-100'>
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
              }
            } else {
              echo "Tidak ada data kamera.";
            }

            $conn->close();
            ?>

          </ul>

        </div>
      </section>

    </article>
  </main>


  <script src="./assets/js/script.js"></script>

  <script>
    function buyNow(productId) {
      window.location.href = `../order/index.php?product_id=${productId}`;
    }

    function goToLogOut() {
      window.location.href = '../loginreg/logout.php';
    }
    function goBack() {
      window.history.back();
    }

    window.addEventListener('scroll', function () {
      var header = document.querySelector('.header');
      if (window.scrollY > 0) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

  </script>

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="listcamera.js"></script>

</body>

</html>