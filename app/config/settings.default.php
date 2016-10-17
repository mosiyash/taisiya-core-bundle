<?php

return [
    'bin' => [
        'taisiya' => 'php '.dirname(dirname(__DIR__)).'/bin/taisiya',
    ],
    'phinx' => [
        'paths' => [
            'migrations' => dirname(__DIR__).'/db/migrations',
            'seeds'      => dirname(__DIR__).'/db/seeds',
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_database'        => 'development',
            'production'              => [
                'adapter' => 'mysql',
                'host'    => 'localhost',
                'name'    => 'taisiya_prod',
                'user'    => 'root',
                'pass'    => 'root',
                'port'    => 3306,
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host'    => 'localhost',
                'name'    => 'taisiya_dev',
                'user'    => 'root',
                'pass'    => 'root',
                'port'    => 3306,
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host'    => 'localhost',
                'name'    => 'taisiya_test',
                'user'    => 'root',
                'pass'    => 'root',
                'port'    => 3306,
                'charset' => 'utf8',
            ],
        ],
    ],
];
