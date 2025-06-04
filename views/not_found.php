<?php

$message = ""; // Message that will display below error code
$code = http_response_code() >= 400 ? http_response_code() : 404; // If there is no error code, will show 404 since path is not valid
// Switch message according to error code
switch ($code) {
  case 400:
    $message = "bad request";
    break;
  case 401:
    $message = "unauthorized";
    break;
  case 402:
    $message = "payment required";
    break;
  case 403:
    $message = "forbidden";
    break;
  case 404:
    $message = "not found";
    break;
  case 405:
    $message = "method not allowed";
    break;
  case 406:
    $message = "not acceptable";
    break;
  case 407:
    $message = "proxy authentication required";
    break;
  case 408:
    $message = "request time-out";
    break;
  case 409:
    $message = "conflict";
    break;
  case 410:
    $message = "gone";
    break;
  case 411:
    $message = "length required";
    break;
  case 412:
    $message = "precondition failed";
    break;
  case 413:
    $message = "request entity too large";
    break;
  case 414:
    $message = "request-uri too large";
    break;
  case 415:
    $message = "unsupported media type";
    break;
  case 500:
    $message = "internal server error";
    break;
  case 501:
    $message = "not implemented";
    break;
  case 502:
    $message = "bad gateway";
    break;
  case 503:
    $message = "service unavailable";
    break;
  case 504:
    $message = "gateway time-out";
    break;
  case 505:
    $message = "http version not supported";
    break;
  default:
    $message = "not found";
    break;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include(__DIR__ . "/../templates/meta.php");  ?>
    <link rel="stylesheet" href="/assets/styles/not-found.css" type="text/css" />
  </head>
  <body>
    <?php include(__DIR__ . "/../templates/header.php");  ?>
    <div class="not-found">
      <h2>Error <?= $code ?></h2>
      <h3><?= $message ?></h3>
    </div>
    <?php include(__DIR__ . "/../templates/footer.php");  ?>
  </body>
</html>