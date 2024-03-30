<?php
declare(strict_types=1);

use App\Controller\BbsController;
use App\Controller\FinalExamController;
use App\Controller\HelloController;
use App\Controller\HomeController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// 初期に書いてあるルーティング
$app->get('/hello/{name}', HelloController::class . ':index');

// 追加のルーティング
$app->get('/', HomeController::class);

// BBS
$app->get('/bbs/', BbsController::class . ':index')->setName('bbs.index');
$app->post('/bbs/', BbsController::class . ':create')->setName('bbs.create');

//
$app->get('/final_exam/', FinalExamController::class . ':index')->setName('final_exam.index');
$app->post('/final_exam/', FinalExamController::class . ':create')->setName('final_exam.create');


$app->get('/bbs/test', BbsController::class . ':test');
