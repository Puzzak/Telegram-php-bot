//Simple message
Request(
    "sendMessage",
    array(
        'chat_id' => $chat_id,
        "text" => $text
    )
);
//Custom keyboard
Request(
    "sendMessage",
    array(
        'chat_id' => $chat_id,
        "text" => $text,
        'reply_markup' => array(
            'keyboard' => array(
                array(
                    'btn 1-1',
                    'btn 1-2'
                ),
                array(
                    'btn 2-1',
                    'btn 2-2'
                ),
                array(
                    'btn 3'
                )
            ),
            'one_time_keyboard' => true,
            'resize_keyboard' => true
        )
    )
);
        
//Reply
Request(
    "sendMessage",
    array(
        'chat_id' => $chat_id,
        "reply_to_message_id" => $message_id,
        "text" => $text
    )
);

//Inline buttons
Request(
    "sendMessage",
    array(
        'chat_id' => $chat_id,
        "text" => "Buttons",
        'reply_markup' => array(
            'inline_keyboard' => array(
                array(
                    array(
                        'text'=>'btn 1',
                        'callback_data'=> 'oneoneone'
                    ),
                    array(
                        'text'=>'btn 2',
                        'callback_data'=> 'twotwotwo'
                    )
                )
            )
        )
    )
);
