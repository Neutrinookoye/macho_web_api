<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class BlogController extends Controller
{
    //
    public function index()
    {
        try{
            $blogs = QueryBuilder::for(Blog::class)
            ->allowedIncludes(['category', 'tags'])
            ->allowedFilters([
                'category.type',
            ])
            ->where('status', 1)
            ->with(['category', 'tags'])
            ->paginate(10);

            // dd($blogs);
            return response()->json([
                'data' => [
                    'blogs' => $blogs,
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
