Request(
    "answerInlineQuery", array(
        'inline_query_id' => $id,
        "results" => array(
            array(
                'type' => "photo",
                'id' => $id,
                'reply_markup' => array(
                    'inline_keyboard' => array(
                        array(
                            array(
                                'text'=>'GoTo',
                                'url'=> 'https://instagram.com/Puzzaks'
                            )
                        )
                    )
                ),
                'caption' => "Photo Caption",
                'photo_url' => "https://projects.humanz.space/bots/puzzak/CAMERAGALAXY.jpg",
                'thumb_url' => "https://projects.humanz.space/bots/puzzak/CAMERAGALAXY.jpg"
            )
        )
    )
);
