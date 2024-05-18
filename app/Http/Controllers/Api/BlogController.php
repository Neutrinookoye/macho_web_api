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
            ->allowedIncludes(['category'])
            ->allowedFilters([
                'category.type',
            ])
            ->where('status', 1)
            ->paginate(10);

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

    public function show($blog_id)
    {
        try{
            $blog = Blog::where('id', $blog_id)->where('status', 1)->first();

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
            $blog = Blog::where('is_featured', 1)->get();

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
