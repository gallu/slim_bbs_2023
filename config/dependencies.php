<?php  // dependencies.php
declare(strict_types=1);
// DIC configuration

use SlimLittleTools\Middleware\CsrfGuard;

return function (\DI\Container $container, \Slim\App $app) {
    // view renderer
    $container->set(
        'renderer' ,function () use($container, $app) {
            $settings = $container->get('settings')['renderer'];
            $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($settings['template_path']));
            //
            return $twig;
        }
    );
    // DB handle
    $container->set(
        'dbh' ,function () use($container, $app) {
            //　接続用情報
            $settings = $container->get('settings')['db'];

            $host = $settings['host'];
            $charset = $settings['charset'];
            $dbname = $settings['dbname'];
            $user = $settings['user'];
            $pass = $settings['pass'];

            // 接続
            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            $options = [
                \PDO::ATTR_EMULATE_PREPARES => false,  // エミュレート無効
                \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,  // 複文無効
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,  // エラー時に例外を投げる(好み)
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ];
            //
            try {
                $dbh = new \PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e){
                echo $e->getMessage(); // XXX 実際は出力はしない(logに書くとか)
                exit;
            }

            return $dbh;
        }
    );

    //
    $container->set(
        'router' ,function () use($container, $app) {
            return $app->getRouteCollector();
        }
    );
};
