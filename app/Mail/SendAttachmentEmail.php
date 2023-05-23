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

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Attachment Email',
        );
    }

    public function build()
    {
        $attachmentPath = public_path('path/to/attachment.pdf');
        $attachmentName = 'attachment.pdf';

        return $this->subject('Email with Attachment')
            ->to('recipient@example.com')
            ->attach($attachmentPath, [
                'as' => $attachmentName,
                'mime' => 'application/pdf',
            ])
            ->view('emails.attachment');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
