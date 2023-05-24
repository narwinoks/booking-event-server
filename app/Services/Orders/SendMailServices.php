<?php

namespace App\Services\Orders;

use App\Interfaces\OrderDetailInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\TicketsInterface;
use App\Mail\SendAttachmentEmail;
use App\Traits\ApiResponse;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SendMailServices
{
    use ApiResponse;
    protected $ticketsInterface;
    protected $orderInterface;
    protected $orderDetailInterface;
    public function __construct(TicketsInterface $ticketsInterface, OrderInterface $orderInterface, OrderDetailInterface $orderDetailInterface)
    {
        $this->ticketsInterface = $ticketsInterface;
        $this->orderInterface = $orderInterface;
        $this->orderDetailInterface = $orderDetailInterface;
    }
    public function sendMailTicket($orderId)
    {
        try {
            $order = $this->orderInterface->getOrderWithDetailTicket($orderId);

            // generate pdf 
            foreach ($order->orderItem as $key => $item) {
                $pdfContent =  $this->generatePdfFile($item->id);
                // Save PDF to a file
                $filename = time() . $item->id . ".pdf";
                $this->orderDetailInterface->updateOrderItem($item->id, ['file' => $filename]);
                $pdfPath = public_path('assets/files/pdf/' . $filename);
                file_put_contents($pdfPath, $pdfContent);
            }

            $mailData = [
                'order' => $order
            ];
            Mail::to($order->email)->send(new SendAttachmentEmail($mailData));
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    protected function generatePdfFile($id)
    {
        $data = $this->orderDetailInterface->getOrderDetailWithOrderTicket($id);
        $pdfContent = View::make('ticket', ['data' => $data])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->output();
    }
}
