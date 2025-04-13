<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    //
    public function index()
    {
        $events = Event::orderBy('created_at', 'DESC')->get();
        // foreach($events as $event)
        // {
        //     $user_id = $event->created_by;
        //     $user = User::find($user_id);
        //     $event->created_by_name = $user->name;
        // }
        return view('admin.event.index', compact('events'))   ;
    }

    public function createEvent(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                // dd($request);
                $request->validate([
                    'title'        => 'bail|required|string',
                    'start_time'   => 'bail|required',
                    'end_time'     => 'bail|required',
                    'location'     => 'bail|nullable|string',
                    'description'  => 'bail|required',
                    'status'       => 'nullable|string',
                    'is_featured'  => 'nullable|integer',
                    'event_image'  => 'bail|required|image',
                    'images'       => 'bail|array',
                ]);
                // dd($request);

                $slug = Str::slug($request->title);

                $checkevent = Event::where('slug', $slug)->first();
                if ($checkevent) {
                    return redirect()->back()
                        ->with('danger', 'Sorry! You have already added this event.')
                        ->withInput();
                }

                if ($request->is_featured) {
                    $featuredEventsCount = Event::where('is_featured', 1)->count();
                    if ($featuredEventsCount >= 3) {
                        return redirect()->back()
                            ->with('danger', 'Sorry! Only 3 events can be featured at a time.');
                    }
                }

                $eventImageUrl = null;
                if ($request->hasFile('event_image')) {
                    $event_image_path = public_path("uploads/events/");
                    $event_image = $request->file("event_image");
                    $event_image_name = Str::random(16) . '.' . $event_image->extension();
                    $event_image->move($event_image_path, $event_image_name);
                    $eventImageUrl = asset('uploads/events/' . $event_image_name);
                }else{
                    $eventImageUrl = null;
                }

                $event = Event::create([
                    'title'       => $request->title,
                    'slug'        => $slug,
                    'start_time'  => $request->start_time,
                    'end_time'    => $request->end_time,
                    'location'    => $request->location,
                    'description' => $request->description,
                    'status'      => $request->status,
                    'is_featured' => $request->is_featured ?? 0,
                    'event_image' => $eventImageUrl,
                    // 'created_by'  => Auth::user()->id,
                ]);

                if ($request->hasFile('images')) {
                    $image_path = public_path("uploads/events/");
                    foreach ($request->file('images') as $image) {
                        $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                        Log::info($image);
                        Log::info($image_name);
                        Log::info($image_path);
                        $image->move($image_path, $image_name);
                        $eventImage = EventImage::create([
                            'event_id' => $event->id,
                            'image'    => asset('uploads/events/' . $image_name),
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Event created successfully');
            } catch (ValidationException $e) {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            }
        } else {
            try {
                return view('admin.event.create');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editEvent(Request $request, $event_id)
    {
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request);
                 $request->validate([
                    'title'        => 'bail|required|string',
                    'start_time'   => 'bail|required',
                    'end_time'     => 'bail|required',
                    'location'     => 'bail|nullable|string',
                    'description'  => 'bail|required',
                    'status'       => 'nullable|string',
                    'is_featured'  => 'nullable|integer',
                    'event_image'  => 'bail|nullable|image',
                    'images'       => 'bail|array',

                ]);
                // dd($request);

                $slug = Str::slug($request->title);

                $checkevent = Event::where('slug', $slug)->where('id', '!=', $event_id)->first();
                if($checkevent)
                {
                    return redirect()->back()->with('danger', 'Sorry! An project alredy exists with this name.')->withInput();
                }

                if ($request->is_featured) {
                    $featuredEventsCount = Event::where('is_featured', 1)->count();
                    if ($featuredEventsCount >= 3) {
                        return redirect()->back()->with('danger', 'Sorry! Only 3 events can be featured at a time.');
                    }
                }

                $event = Event::find($event_id);
                // dd($event);

                if($request->hasFile('event_image'))
                {
                    $event_image_path = public_path("uploads/events/");
                    $event_image = $request->file("event_image");
                    $event_image_name = Str::random(16) . '.' . $event_image->extension();
                    $event_image->move($event_image_path, $event_image_name);
                    $eventImageUrl = asset('uploads/events/' . $event_image_name);
                }else{
                    $eventImageUrl = $event->event_image;
                }

                $event->update([
                    'title'       => $request->title,
                    'slug'        => $slug,
                    'start_time'  => $request->start_time,
                    'end_time'    => $request->end_time,
                    'location'    => $request->location,
                    'description' => $request->description,
                    'status'      => $request->status,
                    'is_featured' => $request->is_featured ?? 0,
                    'event_image' => $eventImageUrl,
                    // 'last_edited_by'  => Auth::user()->id,
                ]); 


                if ($request->hasFile('images')) {
                    $currentImageCount = EventImage::where('event_id', $event_id)->count();
                    $newImages = $request->file('images');
                    $totalImagesCount = $currentImageCount + count($newImages);
                    
                    if ($totalImagesCount > 10) {
                        return redirect()->back()->with('danger', 'You can only upload up to 10 images for a project.')->withInput();
                    }

                    if ($request->hasFile('images')) {
                        $currentImageCount = EventImage::where('event_id', $event_id)->count();
                        $newImages = $request->file('images');
                        $totalImagesCount = $currentImageCount + count($newImages);

                        if ($totalImagesCount > 10) {
                            return redirect()->back()->with('danger', 'You can only upload up to 10 images for a project.')->withInput();
                        }

                        $image_path = public_path("uploads/events/");
                        foreach ($newImages as $image) {
                            $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                            $image->move($image_path, $image_name);
                                $eventImage = EventImage::create([
                                    'event_id' => $event->id,
                                    'image' => asset('uploads/events/' . $image_name),
                                ]);
                        }
                    }
                }

                return redirect()->back()->with('success', 'Event updated successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $event = Event::find($event_id);
                return view('admin.event.edit', compact('event'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function removeImage($event_id, $image_id)
    {
        $image = EventImage::where('event_id', $event_id)->where('id', $image_id)->first();
        $image_delete_path = public_path("uploads/events/".$image->image);
        if(File::exists($image_delete_path)) {
            File::delete($image_delete_path);
        }
         
        $image->delete();
        return redirect()->back()->with('success', 'Event image deleted successfully');
    }
}
