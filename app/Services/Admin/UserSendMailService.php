<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-19
 * Time: 11:59
 */

namespace App\Services\Admin;

use App\Services\SendMailService;

class UserSendMailService extends SendMailService
{
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

        parent::sendTo($to, $subject, $markDown, $content, $attaches, $from, $fromName, $replyTo, $returnPath, $bcc);
    }
}