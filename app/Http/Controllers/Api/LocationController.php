<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function index()
    {
        try{

            $locations = Location::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

            return response()->json([
                'data' => [
                    'locations' => $locations,
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
