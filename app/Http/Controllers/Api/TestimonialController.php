<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    //
    public function index()
    {
        try{

            $testimonials = Testimonial::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

            return response()->json([
                'testimonials' => $testimonials,

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
            $testimonial = Testimonial::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'testimonial' => $testimonial,

            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
