<?php

namespace App\Repositories;

use App\Interfaces\EventInterface;
use App\Models\Event;

class EventRepository implements EventInterface
{
    public function getEvent($request)
    {
        $events = Event::query();
        $events->when($request->get('type') == 'popular', function ($events) {
            $events->where('date', '>=', date('Y-m-d'));
            $events->limit(6);
            $events->inRandomOrder();
        });
        $events->when($request->get('location'), function ($events) use ($request) {
            $locations = explode(",", $request->get('location'));
            $events->whereIn('location', $locations);
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
            $events->whereHas('ticket', function ($query) use ($priceMin, $priceMax) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            });
        })->with('ticket');

        $events->with('ticket');
        return $events->paginate(6);
    }
}
