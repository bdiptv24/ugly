<?php

// proxy.php

header('Content-Type: application/x-mpegURL');

$tvUrl = isset($_GET['tv']) ? $_GET['tv'] : '';

if (empty($tvUrl)) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid request';
    exit();
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tvUrl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

echo curl_exec($ch);

curl_close($ch);

?>
