<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Cùng học cùng giỏi cùng vui với cunghocvui | cunghocvui.com", // set false to total remove
            'description'  => 'Hệ thống toàn bộ các bài giải bài tập ngắn gọn, đầy đủ, bám sát theo nội dung sách giáo khoa giúp các bạn học tốt hơn', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [
                "Hỗ trợ học tập", "giải bài tập",
                "tài liệu học tập Toán học", "Văn học",
                "Soạn văn",
                "Tiếng Anh", "Lịch sử", "Địa lý"],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove,
            'image'        => 'default/img/fb_cunghocvui.png',
            'suffix'       => ' | CungHocVui',
            'additional_title' => ' | Cùng học vui',
            'additional_category_title' => ' | Giải bài tập | Hướng dẫn học tập'
         ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => ' | Cùng học vui!', // set false to total remove
            'description' => ' | Cùng học cùng vui', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
