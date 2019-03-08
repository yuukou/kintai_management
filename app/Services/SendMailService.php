<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-19
 * Time: 12:07
 */

namespace App\Services;

use App\Mail\Mail as Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailService
{
    /**
     *メール送信処理（publicは多いので、privateは最上部に設置）
     *
     * @param string $to 宛先
     * @param string $subject 件名
     * @param string $markDown メールテンプレート
     * @param array $content メールテンプレートへの引数情報
     * @param string|null $attaches 添付ファイル
     * @param string $from 差出人アドレス
     * @param string $fromName 差出人
     * @param string $replyTo 返信先
     * @param string $returnPath 送信エラー時の返信先
     * @param string $bcc BCC
     */
    protected function sendTo($to, $subject, $markDown, $content, $attaches, $from, $fromName, $replyTo, $returnPath, $bcc)
    {
        Mail::to($to)->queue(new Mailable($subject, $markDown, $content, $attaches, $from, $fromName, $replyTo, $returnPath, $bcc));
        Log::info('メール送信完了', compact('to', 'subject', 'from', 'fromName', 'replyTo', 'returnPath', 'bcc', 'markDown', 'attaches', 'content'));
    }

    public function sendMail(array $data)
    {
        $to = $data['email'];
        $subject = trans('email.register.subject');
        $markDown = trans('emails.register');
        $content = $data;
        $attaches = null;
        $from = trans('email.register.from');
        $fromName = trans('email.register.from_name');
        $replyTo = trans('email.register.reply_to');
        $returnPath = '';
        $bcc = '';

        $this->sendTo($to, $subject, $markDown, $content, $attaches, $from, $fromName, $replyTo, $returnPath, $bcc);
    }
}