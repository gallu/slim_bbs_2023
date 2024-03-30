<?php // by_environment_config_dev.php
declare(strict_types=1);

/*
 * 環境に依存する設定(dev)
 */

// デバッグ表示をonにしておく
// XXX本番用の設定ならoffに
ini_set('display_errors', 1);
error_reporting(-1);

// Noticeであろうとも、エラーが出たら速やかに例外をぶん投げる
set_error_handler(
  function ($errno, $errstr, $errfile, $errline) {
    if (0 !== $errno & error_reporting()) {
        throw new ErrorException( $errstr, 0, $errno, $errfile, $errline);
    }
  }
);

/* 設定本体 */
return [
    'db' => [
        'host' => 'localhost',
        'charset' => 'utf8mb4',
        'dbname' => 'gallu',
        'user' => 'gallu',
        'pass' => 'gallu',
    ],
];
