<?php
$composer_data = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);

$settings = [
    "title"=> "Bootstrap 4.4 theme",
    "slug"=> "btfourpointfour",
    "thumbnail"=> "https://placehold.jp/300x160.png",
    "excerpt"=> "Bootstrap 4.4 theme",
    "description"=> "Bootstrap 4.4 theme",
    "download_link"=> "",
    "author_name"=> "btfourpointfour",
    "author_website"=> "https://vaah.dev",
    "version"=> $composer_data['version'],
    "is_migratable"=> true,
    "is_sample_data_available"=> true,
    "db_table_prefix"=> "vh_btfourpointfour_",
    "providers"=> [
        "\\VaahCms\\Themes\\BtFourPointFour\\Providers\\BtFourPointFourServiceProvider"
    ],
    "aside-menu-order"=> null
];

$config_data = array_merge($composer_data, $settings);


return $config_data;
