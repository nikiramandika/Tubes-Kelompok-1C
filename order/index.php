<?php

include '../includes/koneksi.php';
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$sql = "SELECT nama, harga, foto FROM kamera WHERE id = $productId";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE-edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment</title>
  <link rel="shortcut icon" href="../photo-camera-svgrepo-com.svg" type="image/svg+xml">

  <link rel="stylesheet" href="style.css" />

  <link
    href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
    rel="stylesheet" />
  <style>
    .required-warning {
      display: none;
      color: red;
      font-size: 12px;
    }

    .input-default:invalid+.required-warning {
      display: inline;
    }
  </style>
</head>

<body>
  <main class="container">
    <h1 class="heading">
      <ion-icon name="cart-outline"></ion-icon> Shopping Cart
    </h1>
    <button class="Btnn" onclick="goBack()">
      <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
        <path
          d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
        </path>
      </svg>
      <span>Back</span>
    </button>
    <div class="item-flex">
      <section class="checkout">
        <h2 class="section-heading">Payment Details</h2>

        <div class="payment-form">
          <form action="process_payment.php" method="post">
            <div class="nama">
              <label for="nama" class="label-default">Name</label>
              <input type="text" id="nama" name="nama" class="input-default" />
              <span class="required-warning" id="namaWarning">This field is required</span>
            </div>
            <input type="hidden" name="total_payment" id="total_payment" value="">
            <input type="hidden" name="tax_value" id="tax_value" value="">
            <input style="display: none;"type="text" name="quantities" id="quantities" value="">
            

            <div class="alamat">
              <label for="alamat" class="label-default">Address</label>
              <input type="text" id="alamat" name="alamat" class="input-default" />
              <span class="required-warning" id="alamatWarning">This field is required</span>
            </div>

            <div class="payment-method">
              <button type="button" id="cashondelivery" class="method selected">
                <img src="../assets/images/cod.png" width="40px">
                <span>Cash On Delivery</span>
                <ion-icon class="checkmark fill" name="checkmark-circle"></ion-icon>
              </button>

              <button disabled type="button" id="cardBtn" class="method">
                <ion-icon name="card"></ion-icon>
                <span>Credit Card (Coming Soon)</span>
                <ion-icon class="checkmark" name="checkmark-circle"></ion-icon>
              </button>
            </div>
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productId); ?>">
            <button id="payButton" name="payButton" class="btn btn-primary">
              <b>Pay</b> <span id="payAmount">2.15</span>
            </button> 
          </form>
        </div>
      </section>


      <section class="cart">
        <div class="cart-item-box">
          <h2 class="section-heading">Order Summery</h2>
          <?php

          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $harga_database = $row["harga"];
            $harga_tampilan = number_format($harga_database, 0, ',', '.');

            echo '<div class="product-card">
            <div class="card">
            <div class="img-box">
            <img src="../assets/images/' . $row["foto"] . '" alt="' . $row["nama"] . '" width="80px" class="product-box" />
                </div>
                <div class="detail">
                <h4 class="product-name">' . $row["nama"] . '</h4>
                <div class="wrapper">
                <div class="product-qty">
                <button id="decrement">
                <ion-icon name="remove-outline"></ion-icon>
                </button>
                <span id="quantity">1</span>
                <button id="increment">
                <ion-icon name="add-outline"></ion-icon>
                </button>
                </div>
                <div class="price">Rp. <span id="pricehidden">' . $harga_tampilan . '</span></div>
                <div class="price" style="display: none;">Rp. <span id="price">' . $row["harga"] . '</span></div>
                    </div>
                    </div>
                    </div>
                    </div>';
          } else {
            echo "Produk tidak ditemukan.";
          }

          $conn->close();
          ?>

        </div>

        <div class="wrapper">
          <div class="discount-token">
            <label for="discount-token" class="label-default">Gift card/Discount code</label>
            <div class="wrapper-flex">
              <input type="text" name="discount-token" id="discount-token" class="input-default" />
              <button class="btn-outline">Apply</button>
            </div>
          </div>

          <div class="amount">
            <div class="subtotal">
              <span>Subtotal</span>
              <span id="subtotal"></span>
            </div>
            <div class="tax">
              <span>Tax</span><span id="tax"></span>
            </div>
            <div class="shipping">
              <span>Shipping</span>
              <span>Rp <span id="shipping">0.00</span></span>
            </div>
            <div class="total">
              <span>Total</span>
              <span id="total">2.15</span>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).ready(function () {

      $("#nama, #alamat").prop("required", true);

      $("#nama").on("input", function () {

        if ($(this).val() !== "") {
          $(this).prop("required", false);
        } else {
          $(this).prop("required", true);
        }
      });

      $("#alamat").on("input", function () {

        if ($(this).val() !== "") {
          $(this).prop("required", false);
        } else {

          $(this).prop("required", true);
        }
      });
    });
  </script>

  <script src="script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>

    function goBack() {
      window.history.back();
    }

  </script>

</body>

</html>