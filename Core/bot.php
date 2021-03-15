    Simple telegram Bot solution
    Copyright (C) <2020>  <Artem 'Puzzak' Lapikura>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see https://www.gnu.org/licenses/
<?php
define('token', '');//Insert your token here!

function Request($method, $parameters) {
    foreach ($parameters as $key => &$val) {$val = json_encode($val);}
    return json_decode(curl_exec(curl_init('https://api.telegram.org/bot'.token.'/'.$method.'?'.http_build_query($parameters))), true)['result'];
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
    $replytoid=$message['reply_to_message']['message_id'];
    $replytouser_id = $message['reply_to_message']['from']['id'];
    $username=$message['chat']['username'];
    $sendername=$message['from']['username'];
    $replaytosendername=$message['reply_to_message']['from']['username'];
    $newinchat=$message['new_chat_members'];
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
    $id=$callback_query['id'];
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

function ProcInline($inline_query) {
    $id=$inline_query[id];
    $userid=$inline_query[from][id];
    $is_bot=$inline_query[from][is_bot];
    $fname=$inline_query[from][first_name];
    $lname=$inline_query[from][last_name];
    if(isset($lname)){
        $user_name ="$fname $lname";
    }else{
        $user_name=$fname;
    }
    $username=$inline_query[from][username];
    $language=$inline_query[from][language_code];
    $query=$inline_query[query];
    $offset=$inline_query[offset];

    /*
    Actions on inline
    (Actually, if you didn`t use it, you can delete this function)
    */
    Request(
    "sendMessage",
    array(
        'chat_id' => $userid,
        "text" => $query
    )
    );

}
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (isset($update["message"])) {Processing($update["message"]);}
if (isset($update["callback_query"])) {ProcQuery($update["callback_query"]);}
if (isset($update["inline_query"])) {ProcInline($update["inline_query"]);}
?>
