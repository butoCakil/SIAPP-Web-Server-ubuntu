<?php
// beri feedback
$array = array(
    "0" => array(
        "message" => "404",
        "info" => "ERROR. Method Not Allowed"
    )
);

// encode array to json
$json = json_encode(array('respon' => $array));

require("vendor/autoload.php"); // Memuat pustaka phpMQTT

$host = "localhost";
$port = 1883;
$username = "ben";
$password = "1234";
// $topic = "responServer";
$topic = "responServer_" . $nodevice; // Menggunakan topik "responServer" dengan tambahan ID perangkat
$message = @$jsonString ? $jsonString : "{" . $json . "}";

// $infoValue = $message['respon']['info'];

if ($mqtt->connect(true, NULL, $username, $password)) {
    echo "Berhasil kirim balasan ke \"$topic\"";
    echo "\n";
    // echo $infoValue;
    // echo "\n";
    echo "\n";
    $mqtt->publish($topic, $message, 0);
} else {
    echo "Koneksi \"$topic\" gagal.\n";
    echo "\n";
}

$mqtt->close();

