<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string $inSubject */
    private $inSubject;

    /** @var string $inMarkDown */
    private $inMarkDown;

    /** @var array $inContent */
    private $inContent;

    /** @var string $inAttaches */
    private $inAttaches;

    /** @var string $inFrom */
    private $inFrom;

    /** @var string $inFromName */
    private $inFromName;

    /** @var string $inReplyTo */
    private $inReplyTo;

    /** @var string $inReturnPath */
    private $inReturnPath;

    /** @var string $inBcc */
    private $inBcc;

    /**
     * Mail constructor.
     *
     * @param string $inSubject
     * @param string $inMarkDown
     * @param array $inContent
     * @param string $inAttaches
     * @param string $inFrom
     * @param string $inFromName
     * @param string $inReplyTo
     * @param string $inReturnPath
     * @param string $inBcc
     */
    public function __construct($inSubject, $inMarkDown, $inContent, $inAttaches, $inFrom, $inFromName, $inReplyTo, $inReturnPath, $inBcc)
    {
        $this->inSubject = $inSubject;
        $this->inMarkDown = $inMarkDown;
        $this->inContent = $inContent;
        $this->inAttaches = $inAttaches;
        $this->inFrom = $inFrom;
        $this->inFromName = $inFromName;
        $this->inReplyTo = $inReplyTo;
        $this->inReturnPath = $inReturnPath;
        $this->inBcc = $inBcc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $mailable = $this
            ->from($this->inFrom, $this->inFromName) // 送信元
            ->subject($this->inSubject) // メールタイトル
            ->replyTo($this->inReplyTo)
            ->markdown($this->inMarkDown)// どのテンプレートを呼び出すか
//            ->attach($this->inAttaches)
            ->with(['content' => $this->inContent]) // withオプションでセットしたデータをテンプレートへ受け渡す
            ->withSwiftMessage(function (\Swift_Message $message) {
                 $message->setReturnPath($this->inReturnPath);
             });

        if ($this->inBcc) {
            $mailable->bcc($this->inBcc);
        }

        return $mailable;
    }
}