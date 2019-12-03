<?php
return [
    'aliases' => [
        //'@bower' => '@vendor/bower-asset',
        //'@npm'   => '@vendor/npm-asset',
        //
        '@bower' => dirname(dirname(__DIR__)) . '/node_modules',
        '@npm' => dirname(dirname(__DIR__)) . '/node_modules',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
];
