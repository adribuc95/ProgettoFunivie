<?php
session_start();

session_regenerate_id();
$rawData = $_POST['imgBase64'];
print $rawData;
$filteredData = explode(',', $rawData);
$unencoded = base64_decode($filteredData[1]);
$userid  = session_id();
// name & save the image file
$fp = fopen('images/'.$userid.'.jpg', 'w');
fwrite($fp, $unencoded);
fclose($fp);