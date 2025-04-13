<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventImage;

class EventController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $events = Event::orderBy('created_at', 'DESC')->get();

            return response()->json([
                'events' => $events,
            ], 200);

        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show($slug)
    {
        try{
            $event = Event::where('slug', $slug)
            ->first();
            $event_images = EventImage::where('event_id', $event->id)->get();

            return response()->json([
                'event' => $event,
                'event_images' => $event_images,
            ], 200);

        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function featured()
    {
        try{
            $events = Event::where('is_featured', 1)
            ->get();

            return response()->json([
                'data' => [
                    'events' => $events,
                ]
            ], 200);

        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
