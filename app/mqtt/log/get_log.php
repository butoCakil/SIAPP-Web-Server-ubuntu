<?php
//tanggal dan jam hari ini
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('Y-m-d H:i:s');
$tanggal = date('Y-m-d');
$jam     = date('H:i:s');

$logFile = "tag_$tanggal.log";

// Read the content of the log file
$logContent = file_get_contents($logFile);

// Display the content
echo nl2br($logContent);
