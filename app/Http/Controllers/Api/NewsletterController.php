<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    //
    public function submit(Request $request)
    {
        // dd($request);
        try{
            $validated = $request->validate([
                'email' => 'bail|required|email|string|unique:newsletters,email',
            ]);
            
            $newsletter = Newsletter::create([
                'email' => $validated['email'],
            ]);

            return response()->json([
                'data' => [
                    'message' => 'You have been added to our mailing list',
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
