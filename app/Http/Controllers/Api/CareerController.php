<?php

namespace App\Http\Controllers\Api;

use App\Models\Opening;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class CareerController extends Controller
{
    //
    public function index(Request $request)
    {
        try{

            $query = QueryBuilder::for(Opening::class)
                ->allowedIncludes(['location', 'department'])
                ->allowedFilters(['title', 'role', 'location.slug'])
                ->where('status', 1);

                if ($request->has('location')) {
                    $query->whereHas('location', function ($q) use ($request) {
                        $q->where('name', $request->input('location'));
                    });
                }

                if ($request->has('department')) {
                    $query->whereHas('department', function ($q) use ($request) {
                        $q->where('name', $request->input('department'));
                    });
                }
                 $openings = $query
                ->with(['location', 'department'])
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            return response()->json([
                'data' => [
                    'job_openings' => $openings,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
    public function show($opening_id)
    {
        try{
            $opening = Opening::where('id', $opening_id)->where('status', 1)
            ->with(['location'])
            ->first();

            return response()->json([
                'data' => [
                    'opening' => $opening,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function apply(Request $request, $id)
    {
        // dd($request);
        try{
            $opening = Opening::find($id);
        
            if (!$opening) {
                return response()->json([
                    'message' => 'Job opening not found',
                ], 404);
            }

            $validated = $request->validate([
                'first_name' => 'bail|required|string',
                'last_name' => 'bail|required|string',
                'email' => 'bail|required|email|string',
                'phone' => 'bail|required|numeric',
                'cv' => 'bail|required',
                'cover_letter' => 'bail|nullable',
                'location' => 'bail|required|string',
            ]);

            if($request->hasFile('cv'))
            {
                $cv_file_path = public_path("uploads/cvs/");

                $cv_file = $request->file("cv");
                $cv_file_name = 'CV'.'.'.$cv_file->extension();

                if($cv_file->move($cv_file_path, $cv_file_name))
                {
                    $cv_file_name = $cv_file_name;
                }
            }else{
                $cv_file_name = null;
            }

            // if($request->hasFile('cover_letter'))
            // {
            //     $cover_letter_file_path = public_path("uploads/cover_letter/");

            //     $cover_letter_file = $request->file("cover_letter");
            //     $cover_letter_file_name = 'Cover Letter'.'.'.$cover_letter_file->extension();

            //     if($cover_letter_file->move($cover_letter_file_path, $cover_letter_file_name))
            //     {
            //         $cover_letter_file_name = $cover_letter_file_name;
            //     }
            // }else{
            //     $cover_letter_file_name = null;
            // }
            // dd($cv_file_name);
            
            $apply = Application::create([
                'opening_id' => $id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'cv' => $cv_file_name,
                'cover_letter' => $validated['cover_letter'],
                'location' => $validated['location'],
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Application sent successfully',
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
