<?php

namespace App\Services\Orders;

use App\Interfaces\OrderDetailInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\TicketsInterface;
use App\Mail\SendAttachmentEmail;
use App\Traits\ApiResponse;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SendMailServices
{
    use ApiResponse;
    protected $ticketsInterface;
    protected $orderInterface;
    public function __construct(TicketsInterface $ticketsInterface, OrderInterface $orderInterface, OrderDetailInterface $orderDetailInterface)
    {
        $this->ticketsInterface = $ticketsInterface;
        $this->orderInterface = $orderInterface;
        
    }
    public function sendMailTicket($orderId)
    {
        try {
            $order = $this->orderInterface->getOrderWithDetailTicket($orderId);
            $mailData = [
                'username' => "Wins",
                'url' => "http://localhost:8080",
                'ticket' => $order->orderItem
            ];
            // generate pdf 
            foreach ($order->orderItem as $key => $item) {
                $pdfContent =  $this->generatePdfFile($item->ticket_id, $item->name, $item->name, $item->created_at);
                // Save PDF to a file
                $filename = time() . $item->id . ".pdf";
                $pdfPath = public_path('assets/files/pdf/' . $filename);
                file_put_contents($pdfPath, $pdfContent);
                echo "<br />" . $item->id . "<br/>" . $filename . "<br/>";
            }
            // Mail::to($order->email)->send(new SendAttachmentEmail($mailData));
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    protected function generatePdfFile($title, $subtitle, $name, $date)
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
}
