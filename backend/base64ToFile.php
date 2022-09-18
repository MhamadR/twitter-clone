<?php
header("Access-Control-Allow-Methods:POST");

$jsonReceived = file_get_contents('php://input');

$obj = json_decode($jsonReceived);
$extension = $obj->ext;
$base64 = $obj->base64;
$filePath = "backend/Images/".uniqid().$extension;


file_put_contents($filePath,base64_decode($base64));

echo("uploaded");


?>