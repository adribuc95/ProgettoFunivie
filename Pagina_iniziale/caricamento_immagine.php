<?php
session_start();

$rawData = $_POST['imgBase64'];
if($rawData != "") {
    session_regenerate_id();
    print $rawData;
    $filteredData = explode(',', $rawData);
    $unencoded = base64_decode($filteredData[1]);
    $userid  = session_id();
    // name & save the image file
    $fp = fopen('../immagini_skipass/'.$userid.'.jpg', 'w');
    fwrite($fp, $unencoded);
    fclose($fp);
}