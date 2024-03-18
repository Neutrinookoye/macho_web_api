<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Publication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class PublicationController extends Controller
{
    //
    public function index()
    {
        try{

            $publications = QueryBuilder::for(Publication::class)
            ->allowedIncludes(['category'])
            ->allowedFilters([
                'category.slug',
                'name',
            ])
            ->where('status', 1)
            ->paginate(10);

            return response()->json([
                'data' => [
                    'publications' => $publications,
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
