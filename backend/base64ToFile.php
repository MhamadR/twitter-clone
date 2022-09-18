<?php
header("Access-Control-Allow-Methods:POST");

$jsonReceived = file_get_contents('php://input');

$body = json_decode($jsonReceived);
$filePath = "Images/".time().".png";


file_put_contents($filePath,base64_decode($body));

echo("uploaded");


?>