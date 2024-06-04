<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Service;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    //
    public function index()
    {
        try{

            $brands = Brand::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

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

    public function allBrands()
    {
        try{

            $brands = Brand::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

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

    public function show($slug)
    {
        try{
            $brand = Brand::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'data' => [
                    'brand' => $brand,
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
