<?php
$json_url = "https://bittrex.com/api/v1.1/public/getmarketsummaries";
$json = file_get_contents($json_url);
$data = json_decode($json);
echo "<pre>";
print_r($data);
echo "</pre>";