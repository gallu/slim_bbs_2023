<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HelloController extends BaseController
{
    // 多分「よくある」系の書き方
    public function index(Request $request, Response $response, $args)
    {
        // データを拾う
        $context = [
            'name' => $args['name'],
        ];
        // 出力
        return $this->write($response, 'hello.twig', $context);
    }
}
