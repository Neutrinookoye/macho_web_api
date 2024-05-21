<?php

namespace App\Http\Controllers\Api;

use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectImage;
use Spatie\QueryBuilder\QueryBuilder;

class CaseStudyController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $query = QueryBuilder::for(CaseStudy::class)
            ->allowedIncludes(['project', 'brand', 'service', 'location'])
            ->where('status', 1);
            
            if ($request->has('project')) {
                $query->whereHas('project', function ($q) use ($request) {
                    $q->where('name', $request->input('project'));
                });
            }

            if ($request->has('brand')) {
                $query->whereHas('brand', function ($q) use ($request) {
                    $q->where('name', $request->input('brand'));
                });
            }

            if ($request->has('service')) {
                $query->whereHas('service', function ($q) use ($request) {
                    $q->where('name', $request->input('service'));
                });
            }

            if ($request->has('location')) {
                $query->whereHas('location', function ($q) use ($request) {
                    $q->where('name', $request->input('location'));
                });
            }
            $caseStudy = $query->paginate(10);

            return response()->json([
                'data' => [
                    'caseStudy' => $caseStudy,
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
            $caseStudy = CaseStudy::where('slug', $slug)->where('status', 1)->first();
            $project_images = ProjectImage::where('project_id', $caseStudy->project_id)->get();

            return response()->json([
                'data' => [
                    'caseStudy' => $caseStudy,
                    'images' => $project_images,
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
            $caseStudy = CaseStudy::where('is_featured', 1)->get();

            return response()->json([
                'data' => [
                    'caseStudy' => $caseStudy,
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
