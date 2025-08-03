<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentCalendar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentCalendarController extends Controller
{
    /**
     * Display the content calendar.
     */
    public function index(Request $request)
    {
        $query = ContentCalendar::active();

        // Get current month or requested month
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        // Filter by month and year
        $query->whereMonth('event_date', $month)
              ->whereYear('event_date', $year);

        $events = $query->orderBy('event_date')->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'event_date' => $event->event_date->toDateString(),
                'event_name' => $event->event_name,
                'event_type' => $event->event_type,
                'description' => $event->description,
                'content_ideas' => $event->content_ideas,
                'hashtags' => $event->hashtags,
                'hashtags_string' => $event->getHashtagsStringAttribute(),
            ];
        });

        // Get upcoming events (next 30 days)
        $upcomingEvents = ContentCalendar::active()
            ->upcoming()
            ->where('event_date', '<=', now()->addDays(30)->toDateString())
            ->orderBy('event_date')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'event_date' => $event->event_date->toDateString(),
                    'event_name' => $event->event_name,
                    'event_type' => $event->event_type,
                    'description' => $event->description,
                    'content_ideas' => $event->content_ideas,
                    'hashtags' => $event->hashtags,
                ];
            });

        return Inertia::render('content-calendar', [
            'events' => $events,
            'upcomingEvents' => $upcomingEvents,
            'currentMonth' => $month,
            'currentYear' => $year,
        ]);
    }


}