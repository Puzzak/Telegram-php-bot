/*
TELEGRAM PHP BOT
***
The idea of this bot is to do smallest, easiest and coolest bot ever.
Based on a Telegram Hellobot example.
It need only file below to work!
See code samples in further posts.
Made by Puzzak@HumanZ project
Any questions? inbox@humanz.space
*/
<?php
define('token', '');//Insert your token here!
define('link', 'https://api.telegram.org/bot'.token.'/');

function exec_curl_request($handle) {
    $response = curl_exec($handle);
    $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);
    $response = json_decode($response, true);
    $response = $response['result'];
    return $response;
}

function Request($method, $parameters) {
    if (!$parameters) {$parameters = array();}
    foreach ($parameters as $key => &$val) {
        if (!is_numeric($val) && !is_string($val)) {
            $val = json_encode($val);
        }
    }
    $url = link.$method.'?'.http_build_query($parameters);
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    return exec_curl_request($handle);
}
function Processing($message) {
//here goes your code
}
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (isset($update["message"])) {Processing($update["message"]);}?>
