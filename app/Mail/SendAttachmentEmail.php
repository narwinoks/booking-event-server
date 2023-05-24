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

    public function build()
    {
        $attachmentPaths = [];
        // Loop through each ticket in mailData
        foreach ($this->mailData['order']['orderItem'] as $ticket) {
            // Assuming the file paths are stored in the 'file_path' key of each ticket
            $filePath = public_path('assets/files/pdf/' . $ticket['file']);
            // Add the attachment path to the array
            $attachmentPaths[] = $filePath;
            // Attach the file to the email
            $this->attach($filePath, [
                'as' => $ticket['file'],
                'mime' => 'application/pdf',
            ]);
        }

        return $this->from(env('MAIL_USERNAME'), env('APP_NAME'))
            ->subject('Your Ticket Booking')
            ->view('mail.sendTicket')
            ->with($this->mailData);
    }

    public function attachments(): array
    {
        return [];
    }
}
