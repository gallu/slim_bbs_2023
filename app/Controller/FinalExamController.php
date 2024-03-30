<?php  // BbsController.php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class FinalExamController extends BaseController
{
    // TopPage
    public function index(Request $request, Response $response, $args)
    {
        // 出力
        return $this->write($response, 'final_exam/index.twig', []);
    }

    public function create(Request $request, Response $response, $args)
    {
        $postParams = $request->getParsedBody();
        // var_dump($postParams);

        // validate
        $error = [];
        if ('' === $postParams['input_1']) {
            $error[] = 'input_1 empty';
        }

// var_dump($datum, $error);
        // エラーだったらはじく
        if ([] !== $error) {
            // var_dump($error);
            // exit;
            $context = [
                'error' => $error[0],
            ];
            
            return $this->write($response, 'final_exam/index.twig', $context);
        }

        //
        // var_dump($postParams);
        $context = [
            'input_1' => $postParams['input_1'],
        ];
        // var_dump($context);
        
        return $this->write($response, 'final_exam/index.twig', $context);
    }
}
