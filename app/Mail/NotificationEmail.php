<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->from('pengirim@malasngoding.com')
            ->view('emailku')
            ->with(
                [
                    'nama' => 'Diki Alfarabi Hadi',
                    'website' => 'www.malasngoding.com',
                ]
            );
    }

    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Notification Email',
    //     );
    // }


    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }


    // public function attachments()
    // {
    //     return [];
    // }
}
