<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    //
    public function index()
    {
        try{

            $brands = Brand::where('status', 1)->paginate(10);

            return response()->json([
                'data' => [
                    'brands' => $brands,
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
