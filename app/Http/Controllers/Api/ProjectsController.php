<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectdata;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectsController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $query = QueryBuilder::for(Project::class)
            ->allowedIncludes(['brand', 'service', 'location'])
            ->where('status', 1);
            
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
            $projects = $query
            ->with(['brand', 'service', 'location'])
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

    public function show($slug)
    {
        try{
            $project = Project::where('slug', $slug)->where('status', 1)
            ->with(['brand', 'service', 'location'])
            ->first();
            $project_images = ProjectImage::where('project_id', $project->id)->get();
            $project_data = Projectdata::where('project_id', $project->id)->get();

            return response()->json([
                'data' => [
                    'project' => $project,
                    'project_images' => $project_images,
                    'project_data' => $project_data,
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
            $projects = Project::where('is_featured', 1)
            ->with(['brand', 'service', 'location'])
            ->get();

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
