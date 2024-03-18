<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    //

    public function create(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'bail|required|string',
                'email' => 'bail|required|email|string',
                'phone' => 'bail|required|numeric',
                'subject' => 'bail|required|string',
                'message' => 'bail|required|string',
            ]);
            
            $lead = Lead::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
            ]);

            return response()->json([
                'data' => [
                    'message' => "Thank you for contacting us. Your message has been received, and a member of our team will be in touch with you shortly. We appreciate your interest in our services.",
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
