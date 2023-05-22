<?php

namespace App\Services\Orders;

use App\Repositories\TicketsRepository;
use Illuminate\Support\Str;

class TransactionDetailServices
{
    protected $ticketsRepository;
    public function __construct(TicketsRepository $ticketsRepository)
    {
        $this->ticketsRepository = $ticketsRepository;
    }
    public function makeDetailTransaction($order, $orderData, $user)
    {
        $transactionDetails = [
            'order_id' => $order->id . '-' . Str::random(4),
            'gross_amount'  => 200000
        ];
        $items  = [];
        foreach ($orderData as $key => $data) {
            $ticket     = $this->ticketsRepository->getTicketById($data['ticket_id']);
            $items[] = [
                'id'            => $data['id'],
                'price'         => $ticket->price,
                'quantity'      => 1,
                'name'          => $data['name'],
                'product_name'  => $ticket->name,
                'brand'         => 'project ',
                'category'      => 'Ticket Booking',
            ];
        }

        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $customerDetails = [
            'first_name'    => $user['name'],
            'email'         => $user['email'],
        ];

        $midtransParams = [
            'transaction_details'   => $transactionDetails,
            'item_details'          => $items,
            'customer_details'      => $customerDetails,
        ];

        return $midtransParams;
    }
}
