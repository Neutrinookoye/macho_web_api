<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeadController extends Controller
{
    //

    public function create(Request $request)
    {
        try{
            // dd($request);
            $validated = $request->validate([
                'first_name' => 'bail|required|string',
                'last_name' => 'bail|required|string',
                'job_title' => 'bail|required|string',
                'email' => 'bail|required|email|string',             
                'organization' => 'bail|required|string',
                'country' => 'bail|required|string',
                'services' => 'bail|required|array',
                'services.*' => 'string',
                'brief' => 'bail|required|string',
            ]);

            $services = implode(', ', $validated['services']);

            $lead = Lead::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'job_title' => $validated['job_title'],
                'email' => $validated['email'],
                'organization' => $validated['organization'],
                'country' => $validated['country'],
                'services' => $services,
                'brief' => $validated['brief'],
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
