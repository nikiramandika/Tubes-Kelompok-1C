<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="shortcut icon" href="photo-camera-svgrepo-com.svg" type="image/svg+xml">
    <link rel="stylesheet" href="error.css">
</head>

<body>
    <div class="cont_principal">
        <div class="cont_error">

            <h1><b>403</b></h1>
            <p><b>🚫Access Denied🚫</b></p>
            <p><b>You </b>dont have permission to view this site.</p>
        </div>
        <div class="cont_aura_1"></div>
        <div class="cont_aura_2"></div>
    </div>
</body>

<script>
    window.onload = function () {
        document.querySelector('.cont_principal').className = "cont_principal cont_error_active";

    }
</script>

</html>