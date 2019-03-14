<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-13
 * Time: 10:28
 */

namespace App\Logging;

use App\Monolog\Handler\CustomRotatingFileHandler;
use App\Monolog\Processor\UserProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;

class CreateCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $path = $this->getPath($config['path']);

        $handler = new CustomRotatingFileHandler($path, $config['days'], $config['level_min'], true, 0777, false, $config['level_max']);

        $this->pushProcessor($handler);

        return new Logger('custom_logger', [$handler]);
    }

    /**
     * ログファイルの接頭辞を取得する
     *
     * @param string $path
     * @return string
     */
    private function getPath($path)
    {
        if (php_sapi_name() == 'cli') {
            $prefix = 'console-';
        }
//        一時的にAdminとFrontの区別なしでログを吐く。
//        elseif (isAdmin()) {
//            $prefix = 'admin-';
//        } else {
//            $prefix = 'front-';
//        }

        else{
            $prefix = 'system-';
        }

        return dirname($path).DIRECTORY_SEPARATOR.$prefix.basename($path);
    }

    /**
     * ログに各種情報を追加して出力できるようにする
     *
     * @param StreamHandler $handler
     */
    private function pushProcessor(StreamHandler $handler)
    {
        // クラス名等
        $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']));

        // IPアドレス等
        $handler->pushProcessor(new WebProcessor());

        // ログインIDやセッション情報
        $handler->pushProcessor(new UserProcessor());
    }
}