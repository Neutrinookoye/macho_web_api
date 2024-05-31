<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            $blogs = QueryBuilder::for(Blog::class)
                ->allowedIncludes(['category', 'tags'])
                ->allowedFilters(['category.type'])
                ->where('status', 1)
                ->with(['category', 'tags'])
                ->orderBy('created_at', 'desc') // Corrected 'DSEC' to 'desc'
                ->paginate(10);

            return response()->json([
                'data' => $blogs->items(),
                'meta' => [
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function show($slug)
    {
        try{
            $blog = Blog::where('slug', $slug)
            ->where('status', 1)
            ->with(['category', 'tags'])
            ->first();

            return response()->json([
                'data' => [
                    'blog' => $blog,
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
            $blog = Blog::where('is_featured', 1)
            ->with(['category', 'tags'])
            ->get();

            return response()->json([
                'data' => [
                    'blog' => $blog,
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
