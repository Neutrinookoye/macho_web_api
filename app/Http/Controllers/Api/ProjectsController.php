<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectsController extends Controller
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

            $projects = QueryBuilder::for(Project::class)
            ->allowedIncludes(['brand', 'service', 'location'])
            ->allowedFilters([
                'brand.slug', 
                'service.slug', 
                'location.slug', 
                'name',
            ])
            ->where('status', 1)
            ->paginate(10);

            return response()->json([
                'data' => [
                    'projects' => $projects,
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

            $projects = Project::where('is_featured', 1)->get();

            return response()->json([
                'data' => [
                    'projects' => $projects,
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
