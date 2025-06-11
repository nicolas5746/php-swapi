<?php
// Initialize curl session and set url and options
$ch = curl_init();
$url = "https://api.npoint.io/0274475edb0f9685ef3d";
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch); // Grab url and pass it to the browser
curl_close($ch); // Close curl session

$portfolio = json_decode($result); // Convert JSON object to PHP object
?>

<footer class="footer">
    <a href="<?= $portfolio->url ?>" rel="noopener noreferrer" target="_blank">
        <?= $portfolio->url ?>
    </a>
</footer>