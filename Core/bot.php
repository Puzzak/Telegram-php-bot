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
    $message_id = $message['message_id'];//int
    $chat_id = $message['chat']['id'];//int or string
    $is_bot=$message['chat']['is_bot'];//bool
    $text= $message['text'];//string: max - 4096
    $timestmp=$message['date'];//int - Unix timestamp
    $fname=$message['chat']['first_name'];//string
    $lname=$message['chat']['last_name'];//string
    if(isset($lname)){
        $user_name ="$fname $lname";
    }else{
        $user_name=$fname;
    }
    $caption=$message['caption'];//string
    $sticker=$message['sticker']['file_id'];
    $stickerset=$message['sticker']['set_name'];
    $replytotext=$message['reply_to_message']['text'];
    $replytoid=$message['reply_to_message']['id'];
    $username=$message['chat']['username'];
    /*
    Actions when bot recieves a message
    */
    Request(
    "sendMessage",
    array(
        'chat_id' => $chat_id,
        "text" => "Hey, ".$user_name.", your bot is online. Begin with adding actions or methods. And don`t forget to set botpic, description etc.\nKeep moving forvard!",
        'reply_markup' => array(
            'inline_keyboard' => array(
                array(
                    array(
                        'text'=>'Your Bro',
                        'url'=> 'https://t.me/Puzzak'
                    ),
                    array(
                        'text'=>'Go to source code',
                        'url'=> 'https://github.com/HumanZ-project/Telegram-php-bot/'
                    )
                ),array(
                    array(
                        'text'=>'Go ahead!',
                        'callback_data'=> 'init'
                    )
                )
            )
        )
    )
);
}
function ProcQuery($callback_query) {
    $fname=$callback_query['message']['chat']['first_name'];//string
    $lname=$callback_query['message']['chat']['last_name'];//string
    if(isset($lname)){
        $user_name ="$fname $lname";
    }else{
        $user_name=$fname;
    }

    $chat_id=$callback_query['from']['id'];
    $data=$callback_query['data'];
    $message_id=$callback_query['message']['message_id'];
    $message_text=$callback_query['message']['text'];
    $chat_id=$callback_query['message']['chat']['id'];
    $username=$callback_query['message']['chat']['username'];
    /*
    Actions when user uses buttons under message
    (Actually, if you didn`t use it, you can delete this function)
    */
    if($data=="init"){
        Request("deleteMessage", array('chat_id' => $chat_id, "message_id" => $message_id));
        Request(
            "sendSticker",
            array(
                'chat_id' => $chat_id,
                "sticker" => 'CAACAgIAAxkBAAMtXjKm4rjHrThW1GIY4d6M-n7qL0MAAgIAA_B_LiDKpq1PIGmzahgE'
            )
        );
    }
}
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (isset($update["message"])) {Processing($update["message"]);}
if (isset($update["callback_query"])) {ProcQuery($update["callback_query"]);}
?>
