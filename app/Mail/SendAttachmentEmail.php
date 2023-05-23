<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendAttachmentEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;


    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Attachment Email',
        );
    }

    public function build()
    {
        $attachment1Path = public_path('assets/files/pdf/pdf1.pdf');
        $attachment2Path = public_path('assets/files/pdf/pdf2.pdf');

        return $this->from(env('MAIL_USERNAME'), env('APP_NAME'))
            ->subject('Your Ticket')
            ->attach($attachment1Path, [
                'as' => 'pdf1.pdf',
                'mime' => 'application/pdf',
            ])
            ->attach($attachment2Path, [
                'as' => 'pdf2.pdf',
                'mime' => 'application/pdf',
            ])
            ->view('mail')
            ->with($this->mailData);
    }

    public function attachments(): array
    {
        return [];
    }
}
