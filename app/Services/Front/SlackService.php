<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/21
 * Time: 12:56
 */

namespace App\Services\Front;

trait SlackService
{
    private $message = [
        'icon_emoji' => ':ghost:',
        'channel' => 'kintai試験',
        'username' => 'kintai',
    ];

    public function send()
    {
        $webhook_url = 'https://hooks.slack.com/services/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';
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($this->message),
            ]
        ];

        $response = file_get_contents($webhook_url, false, stream_context_create($options));
        return $response === 'ok';
    }

    public function arrive($shainName)
    {
        $this->message['text'] = $shainName . 'さんが出社しました';
    }

    public function leave($shainName)
    {
        $this->message['text'] = $shainName . 'さんが退社しました';
    }
}