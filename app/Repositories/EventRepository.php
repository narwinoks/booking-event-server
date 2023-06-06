<?php

namespace App\Repositories;

use App\Interfaces\EventInterface;
use App\Models\Event;
use App\Models\Ticket;

class EventRepository implements EventInterface
{
    public function getEvent($request)
    {

        $events = Event::query();

        $events->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->select('events.*')
            ->selectRaw('(SELECT MIN(price) FROM tickets WHERE event_id = events.id) as min_price')
            ->groupBy('events.id')
            ->when($request->get('order') == 'price', function ($query) {
                $query->orderBy('min_price');
            });

        $events->when($request->get('type') == 'popular', function ($events) {
            $events->where('date', '>=', date('Y-m-d'))
                ->limit(6)
                ->inRandomOrder();
        });

        $events->when($request->get('location'), function ($events) use ($request) {
            $locations = explode(",", $request->get('location'));
            $events->whereIn('location', $locations);
        });

        $events->when($request->get('order'), function ($events) use ($request) {
            if ($request->get('order') == "date" || $request->get('order') == "name") {
                $events->orderBy($request->get('order'));
            }
        });
        $events->when($request->get('search'), function ($events) use ($request) {
            $events->where('name', 'LIKE', '%' . $request->get('search') . '%');
        });

        $events->when($request->get('date'), function ($events) use ($request) {
            $events->where('date', '>=', $request->get('date'));
        });

        $events->when($request->get('price_min') && $request->get('price_max'), function ($events) use ($request) {
            $priceMin = $request->get('price_min');
            $priceMax = $request->get('price_max');
            $events->whereBetween('min_price', [$priceMin, $priceMax]);
        });

        return $events->paginate(6);
    }

    public function showEvent($slug)
    {
        $event = Event::with('ticket', 'category')->where('slug', $slug)->first();
        return $event;
    }

    public function getLocation()
    {
        $location = Event::select('id', 'location')->groupBy('id', 'location')->orderByRaw('COUNT(*) DESC')->limit(6)->get();
        return $location;
    }

    public function getEventByTicket($ticketId)
    {
        $event = Ticket::with('event')->where('id', $ticketId)->first();
        return $event;
    }
}
