<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


class TestingPdfController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Certificate of Achievement';
        $subtitle = 'This is to certify that';
        $name = 'John Doe';
        $date = date('Y-m-d');

        // Generate PDF content using Dompdf
        $pdfContent = $this->generatePDFContent($title, $subtitle, $name, $date);

        // Save PDF to a file
        $filename = time() . ".pdf";
        $pdfPath = public_path('assets/files/pdf/' . $filename);
        file_put_contents($pdfPath, $pdfContent);

        return 'PDF saved.';
    }

    private function generatePDFContent($title, $subtitle, $name, $date)
    {
        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'name' => $name,
            'date' => $date,
        ];

        $pdfContent = View::make('ticket', $data)->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->output();
    }


    // // Send email with the PDF attachment
    // $attachmentName = 'certificate.pdf';
    // $recipientEmail = 'narnowin00@gmail.com';

    // Mail::send([], [], function ($message) use ($pdfPath, $attachmentName, $recipientEmail) {
    //     $message->from(env('MAIL_USERNAME'), env('APP_NAME')) // Atur alamat email pengirim
    //         ->to($recipientEmail)
    //         ->subject('Certificate')
    //         ->attach($pdfPath, ['as' => $attachmentName, 'mime' => 'application/pdf']);
    // });
    // // Delete the temporary PDF file
    // unlink($pdfPath);
}
