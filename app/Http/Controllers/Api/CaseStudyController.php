<?php

namespace App\Http\Controllers\Api;

use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class CaseStudyController extends Controller
{
    //
    public function index()
    {
        try{

            // $projects = Project::where('status', 1)->get();

            // $projects = QueryBuilder::for(Project::class)
            // ->allowedFilters(['brand_id', 'service_id', 'location_id'])
            // ->where('status', 1)
            // ->get();

            $caseStudy = QueryBuilder::for(CaseStudy::class)
            ->allowedIncludes(['project', 'brand', 'service', 'location'])
            ->allowedFilters([
                'project.slug', 
                'brand.slug', 
                'service.slug', 
                'location.slug',
                'name',
            ])
            ->where('status', 1)
            ->paginate(10);

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
