<?php
/**
 * @copyright Copyright (C) Logical-Studio Co.,Ltd.
 * @since     2018/08/03
 */
namespace App\Monolog\Handler;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class CustomRotatingFileHandler extends RotatingFileHandler
{
    /**
     * @var int 本プロパティ以下のレベルのみを出力対象にする
     */
    private $maxOutputLevel = Logger::EMERGENCY;

    /**
     * {@inheritdoc}
     */
    public function __construct($filename, $maxFiles = 0, $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false, $maxOutputLevel = Logger::EMERGENCY)
    {
        parent::__construct($filename, $maxFiles, $level, $bubble, $filePermission, $useLocking);
        $this->maxOutputLevel = $maxOutputLevel;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if ($record['level'] <= $this->maxOutputLevel) {
            parent::write($record);
        }
    }
}
