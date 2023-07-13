<?php

namespace App\Services\Orders;

use App\Interfaces\OrderDetailInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\TicketsInterface;
use App\Mail\SendAttachmentEmail;
use App\Models\OrderItem;
use App\Services\Events\TicketService;
use App\Traits\ApiResponse;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SendMailServices
{
    use ApiResponse;
    protected $ticketsInterface;
    protected $orderInterface;
    protected $orderDetailInterface;
    protected $ticketService;
    public function __construct(TicketsInterface $ticketsInterface, OrderInterface $orderInterface, OrderDetailInterface $orderDetailInterface, TicketService $ticketService)
    {
        $this->ticketsInterface = $ticketsInterface;
        $this->orderInterface = $orderInterface;
        $this->orderDetailInterface = $orderDetailInterface;
        $this->ticketService = $ticketService;
    }
    public function sendMailTicket($orderId)
    {
        try {
            $order = $this->orderInterface->getOrderWithDetailTicket($orderId);

            // generate pdf
            foreach ($order->orderItem as $key => $item) {
                // Save PDF to a file
                $filename = time() . $item->id . ".pdf";
                $updateOrderItem = [
                    'code' =>"booking-".Str::random(8),
                    'file' => $filename
                ];
                // update order detail
                $this->orderDetailInterface->updateOrderItem($item->id, $updateOrderItem);
                $pdfContent =  $this->generatePdfFile($item->id);   
                $pdfPath = public_path('assets/files/pdf/' . $filename);
                file_put_contents($pdfPath, $pdfContent);
            }

            $newOrder = $this->orderInterface->getOrderWithDetailTicket($orderId);
            $mailData = [
                'order' => $newOrder
            ];
            // update tickets
            $this->ticketService->updateSoldTicket($order->orderItem[0]->id,  count($order->OrderItem));
            // send mail notification
            Mail::to($order->email)->send(new SendAttachmentEmail($mailData));
        } catch (\Throwable $e) {
            // trow error exception
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
