<?php

namespace App\Http\Controllers\Api;

use App\Models\Award;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class AwardController extends Controller
{
    //
    public function index()
    {
        try{
            $awards = QueryBuilder::for(Award::class)
            ->allowedIncludes(['category'])
            ->allowedFilters([
                'category.type',
            ])
            ->where('status', 1)
            ->paginate(10);

            return response()->json([
                'data' => [
                    'awards' => $awards,
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
            $award = Award::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'data' => [
                    'award' => $award,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function featured()
    {
        try{
            $award = Award::where('is_featured', 1)->get();

            return response()->json([
                'data' => [
                    'award' => $award,
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
