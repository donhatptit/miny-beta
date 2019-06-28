<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Cùng học cùng giỏi cùng vui với cunghocvui | cunghocvui.com", // set false to total remove
            'description'  => ' Hệ thống các phương trình hóa học, chất hóa học đầy đủ và chi tiết nhất. Giúp các em đạt kết quả cao trong học tập.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [
                "phương trình hóa học", "chất hóa học",
                "cân bằng phương trình", "thông tin chất",
                "điều kiện phản ứng",
                "chất tham gia", "chất sản phẩm"],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove,
            'image'        => 'default/img/fb_cunghocvui.png',
            'suffix'       => ' | CungHocVui',
            'additional_title' => ' | Cùng học vui',
            'additional_category_title' => ' | Giải bài tập | Hướng dẫn học tập'
        ],
        'chemicalequation' => [
            'title' => 'Phương trình hóa học đầy đủ chi tiết nhất',
            'description' => 'Toàn bộ các phương trình hóa học đã được cân bằng, tất cả các phương trình hóa học được Cunghocvui thống kê lại đầy đủ dựa theo chương trình Hóa học của Bộ giáo dục và Đào tạo'
        ],
        'chemical' => [
            'title' => 'Chất hóa học - Tổng hợp các chất hóa học đầy đủ nhất',
            'description' => 'Tìm kiếm nhanh nhất các chất hóa học theo tên gọi hay công thức hóa học của chất đó. Đầy đủ các thông tin tên gọi tiếng Anh, màu sắc, trạng thái, khối lượng riêng, nhiệt độ sôi, nhiệt độ tan chảy.',
        ],
        'dissolubilityTable' => [
            'title' => "Bảng tính tan các chất hóa học đầy đủ nhất",
            'description' => "Bảng tính tan - Công cụ tuyệt vời để phân biệt các chất bằng phản ứng hóa học.",
        ],
        'periodicTable' => [
            'title' => "Bảng tuần hoàn các nguyên tố hóa học đầy đủ nhất",
            'description' => "Bảng tuần hoàn các nguyên tố hóa học - Tra cứu các chất hóa học nhanh và đầy đủ nhất.",
        ],
        'electrochemicalTable' => [
            'title' => "Dãy điện hóa chi tiết nhất - Cunghocvui",
            'description' => "Dãy điện hóa cho ta biết độ mạnh tính oxi hóa, tính khử của các kim loại được sắp xếp tăng dần từ bé đến lớn. Từ đó dự đoán chiều của phản ứng giữa 2 cặp oxi hóa - khử.",
        ],
        'reactivityseriesTable' => [
            'title' => "Dãy hoạt động của kim loại chi tiết nhất",
            'description' => "Dãy hoạt động của kim loại - Khi Bà Con Nào Mua Áo Giáp Sắt Nên Sang Phố Hỏi Cửa Hàng Á Phi Âu. Kim loại đứng trước Mg phản ứng với nước ở điều kiện thường tạo thành kiềm và giải phóng H2.",
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
