<?php  // phinx.php

$phinx_config = 
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'development_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];

// dev用の設定上書き
$dev_config = require __DIR__ . '/config/by_environment_config_dev.php';
$dev_config = $dev_config['db'];
$phinx_config['environments']['development']['host'] = $dev_config['host'];
$phinx_config['environments']['development']['charset'] = $dev_config['charset'];
$phinx_config['environments']['development']['name'] = $dev_config['dbname'];
$phinx_config['environments']['development']['user'] = $dev_config['user'];
$phinx_config['environments']['development']['pass'] = $dev_config['pass'];

// var_dump($phinx_config);
return $phinx_config;
