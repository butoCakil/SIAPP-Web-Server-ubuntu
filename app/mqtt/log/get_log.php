<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$getTanggal = @$_GET['date'];

$tanggal = $getTanggal ? $getTanggal : $tanggal;

$logFile = "tag_$tanggal.log";
$logContent = file_get_contents($logFile);
echo nl2br($logContent);
