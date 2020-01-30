//Use link to sticker
Request(
    "sendSticker",
    array(
        'chat_id' => $chat_id,
        "sticker" => 'https://sticker.link.in/webp/format.webp'
    )
);
//or it`s id, get sticker id from $sticker
Request(
    "sendSticker",
    array(
        'chat_id' => $chat_id,
        "sticker" => 'CAACAgIAAxkBAAMtXjKm4rjHrThW1GIY4d6M-n7qL0MAAgIAA_B_LiDKpq1PIGmzahgE'
    )
);
