<?php

//在laravel中，可以通过config()函数轻松获取配置信息，例如config('blog.title')
//就会返回title的值
return [
    'name' => "我的博客",
    'title' => '个人博客',
    'subtitle' => 'ただの人間',
    'description' => 'sos',
    'author' => 'mooNight',
    'page_image' => 'home-bg.jpg',
    'posts_per_page' => 5,
    'rss_size' => 25,
    'uploads' => [
        'storage' => 'public',
        'webpath' => '/storage/uploads',
   ],
    'contact_email' => env('MAIL_FROM'),
];