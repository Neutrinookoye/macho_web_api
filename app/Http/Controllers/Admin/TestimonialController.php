<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class TestimonialController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $testimonials = Testimonial::orderBy('created_at', 'DESC')->get();

            return view('admin.testimonial.index', compact('testimonials'));

        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
    
        }
    }

    public function createTestimonial(Request $request)
    {
        try
        {
            // dd($request);   
            $request->validate([
                'name' => 'bail|required|string',
                'designation' => 'bail|required|string',
                'company' => 'bail|required|string',
                'message' => 'bail|nullable|string',
                'image' => 'bail|nullable',
                'status' => 'nullable|integer',
            ]);
            // dd($request);

            $slug = Str::slug($request->name);

            $testimonial = Testimonial::where('slug', $slug)->first();
            if($testimonial)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this testimonial');
            }

            if($request->hasFile('image'))
            {
                $image_path = public_path("uploads/testimonials/");

                $image = $request->file("image");
                $image_name = Str::random(16).'.'.$image->extension();

                $image->move($image_path, $image_name);
                $imageUrl = asset('uploads/testimonials/' . $image_name);
            }else{
                $imageUrl = null;
            }

            $testimonial = Testimonial::create([
                'name' => $request->name,
                'designation' => $request->designation,
                'company' => $request->company,
                'message' => $request->message,
                'slug' => $slug,
                'image' => $imageUrl,
                'status' => $request->status ?? 0,
                // 'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Testimonial added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editTestimonial(Request $request, $testimonial_id)
    {
        try
        {
            // dd($request);
            $request->validate([
                'name' => 'bail|required|string',
                'designation' => 'bail|required|string',
                'company' => 'bail|required|string',
                'message' => 'bail|nullable|string',
                'image' => 'bail|nullable',
                'status' => 'nullable|integer',
            ]);
            // dd($request);

            $slug = Str::slug($request->name);

            $checktestimonial = Testimonial::where('slug', $slug)->where('id', '!=', $testimonial_id)->first();
            if($checktestimonial)
            {
                return redirect()->back()->with('danger', 'Sorry! A testimonial already exists with this name.');
            }

            $testimonial = Testimonial::find($testimonial_id);

            if($request->hasFile('image'))
            {
                $image_path = public_path("uploads/testimonials/");

                $image = $request->file("image");
                $image_name = Str::random(16).'.'.$image->extension();

                $image->move($image_path, $image_name);
                $imageUrl = asset('uploads/testimonials/' . $image_name);
            }else{
                $imageUrl = $testimonial->image;
            }

            $testimonial->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'company' => $request->company,
                'message' => $request->message,
                'slug' => $slug,
                'image' => $imageUrl,
                'status' => $request->status ?? 0,
                // 'last_edited_by' => auth()->user()->id,
            ]);
            // dd($testimonial);

            return redirect()->back()->with('success', 'Testimonial added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
