<?php

return [
    'app' => [
        'title' => 'XIAG test task',
    ],
    'index' => [
        'title' => 'URL shortener',
        'input_url' => 'Long URL',
        'output_url' => 'Short URL',
        'submit' => 'Do!',
    ],
    'api' => [
        'errors' => [
            'url_invalid' => 'url is not correct',
            'url_not_saved' => 'can not save url to db'
        ],
    ],
];