<?php

namespace App\Http\Controllers\Api;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    //
    public function index(Request $request)
    {
        try{

            if($request->search && $request->search != null)
            {
                $search = $request->search;
                $galleries = Gallery::where('status', 1)->where(function($query) use ($search){
                    $query->where('title', 'like', '%'.$search.'%');
                })->with(['category', 'previewFile'])->get();
            }elseif($request->category && $request->category != null){
                $cats = Category::select('id')->where('slug', $request->category)->get()->toArray();
                $galleries = Gallery::where('status', 1)->whereIn('category_id', $cats)->with(['category', 'previewFile', 'files'])->get();
            }else{
                $galleries = Gallery::where('status', 1)->with(['category', 'previewFile', 'images'])->get();
            }
            $categories = Category::where('status', 1)->get();

            return response()->json([
                'file_url' => 'uploads/galleries/',
                'galleries' => $galleries,
                'categories' => $categories,
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

            $gallery = Gallery::where('slug', $slug)->where('status', 1)->with('images')->first();
            $galleries = Gallery::where('status', 1)->where('id', '!=', $gallery->id)->with(['category', 'previewFile'])->get();

            return response()->json([
                'gallery' => $gallery,
                'galleries' => $galleries
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
