<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geolocation</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
</head>
<body>
    <h1>[Villa] IP Geolocation</h1>
    <div id="resultado-container" style="display:none;">
        <p><strong>IP Detectada:</strong> <span id="ip-display"></span></p>
        <p><strong>Ciudad:</strong> <span id="city-display"></span></p>
        <p><strong>Pais:</strong> <span id="country-display"></span></p>
        <p><strong>Carrier:</strong> <span id="carrier-display"></span></p>
    </div>
</body>
</html>

<script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
<script src="<?= base_url('/public/js/geolocation.js');     ?>"></script>



