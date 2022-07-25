<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simrs3";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function getSignature()
{
  $dataid = "29446";
  $secretKey = "2yM44573CA";


  date_default_timezone_set('UTC');
  $tStamp              = strval(time() - strtotime('1970-01-01 00:00:00'));
  $signature           = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
  $encodedSignature    = base64_encode($signature);
  $urlencodedSignature = urlencode($encodedSignature);

  $header = array(
    "x-cons-id: " . $dataid . "",
    "x-timestamp:" . $tStamp . "",
    "x-signature:" . $encodedSignature . "",
    "Content-Type: application/x-www-form-urlencoded"
  );
  return $header;
}
