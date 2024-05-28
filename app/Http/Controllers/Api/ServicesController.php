<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //
    public function index()
    {
        try{

            $services = Service::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

            return response()->json([
                'data' => [
                    'services' => $services,
                ]
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
            $service = Service::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'data' => [
                    'service' => $service,
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
