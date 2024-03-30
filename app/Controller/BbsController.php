<?php  // BbsController.php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BbsController extends BaseController
{
    // TopPage
    public function index(Request $request, Response $response, $args)
    {
        // 最新20件を取得
        $dbh = $this->container->get('dbh');
        //　プリペアドステートメントの作成
        $sql = 'SELECT * FROM slim_bbses ORDER BY created_at DESC LIMIT :limit OFFSET :offset;';
        $pre = $dbh->prepare($sql);
        // 値をバインド
        $pre->bindValue(":limit", 20, \PDO::PARAM_INT);
        $pre->bindValue(":offset", 0, \PDO::PARAM_INT);
        // SQLを実行
        $r = $pre->execute();
// var_dump($r);
        // データを取得
        $data = $pre->fetchAll();
// var_dump($data);
        
        //
        $context = [
            "data" => $data,
        ];

        // 出力
        return $this->write($response, 'bbs/index.twig', $context);
    }

    public function create(Request $request, Response $response, $args)
    {
        $postParams = $request->getParsedBody();
        // var_dump($postParams);

        // validate
        $datum = [];
        $error = []; 
        // 対象とvalidateパターンを把握
        $params = [
            'name' => 'must',
            'title' => '',
            'body' => 'must',
        ];
        // XXX 後で共通化する
        foreach($params as $key => $val) {
            //　データの取得
            $datum[$key] = (string) ($postParams[$key] ?? '');
            // validate
            if ('must' === $val) {
                if ('' === $datum[$key]) {
                    $error[] = "{$key} validate error";
                }
            }
        }
// var_dump($datum, $error);
        // エラーだったらはじく
        if ([] !== $error) {
            var_dump($error);
            exit;
        }

        //　書き込みブラウザと書き込み元IPアドレスを把握する
//var_dump($request->getServerParams());
//var_dump($_SERVER);
        $datum['user_agent'] = $request->getHeader('User-Agent')[0] ?? '';
        $datum['from_ip'] = $request->getServerParams()['HTTP_X_FORWARDED_FOR']
            ?? $request->getServerParams()['REMOTE_ADDR'];
// var_dump($datum);
// exit;

        // insert
        $dbh = $this->container->get('dbh');
// var_dump($dbh);

        //　プリペアドステートメントの作成
        $sql = 'INSERT INTO slim_bbses(name, title, body, user_agent, from_ip, created_at)
            VALUES(:name, :title, :body, :user_agent, :from_ip, :created_at);
        ';
        $pre = $dbh->prepare($sql);
        // 値のバインド
        foreach($datum as $key => $val) {
            $pre->bindValue(":{$key}", $val, \PDO::PARAM_STR);
        }
        $pre->bindValue(':created_at', date(DATE_ATOM));
        // SQLの実行
        $r = $pre->execute();
// var_dump($r);
// exit;

        // リダイレクト
        return $this->redirect($response, $this->urlFor('bbs.index'));
    }

    public function test(Request $request, Response $response, $args) {
        // var_dump($this->container);
        $ren = $this->container->get('dbh');
        var_dump(spl_object_id($ren));
        $ren2 = $this->container->get('dbh');
        var_dump(spl_object_id($ren2));
var_dump($ren, $ren2);

        return $response;
    }
}
