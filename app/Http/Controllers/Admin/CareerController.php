<?php

namespace App\Http\Controllers\Admin;

use App\Models\Career;
use App\Models\Opening;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Validation\ValidationException;

class CareerController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_job_applications'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $openings = Opening::orderBy('created_at', 'DESC')->get();
        // dd($openings);
        return view('admin.career.index', compact('openings'));
    }

    public function createOpening(Request $request)
    {
        if(!checkPermission('create_job_opening'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'title' => 'bail|required|string',
                    'description' => 'bail|nullable|string',
                    'role' => 'bail|nullable|string',
                    'location' => 'bail|nullable|string',
                    'department' => 'bail|required|string',
                    'experience_level' => 'bail|required|string',
                    'education_requirement' => 'bail|required|string',
                    'employment_type' => 'bail|required|string',
                    'deadline' => 'bail|string',
                    'status' => 'nullable|integer',
                ]);

                $slug = Str::slug($request->department);

                $department = Department::firstOrCreate(
                    ['name' => $request->department],
                    [
                        'name' => $request->department, 
                        'slug' => $slug
                    ]
                );

                $opening = Opening::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'role' => $request->role,
                    'location_id' => $request->location,
                    'department_id' => $department->id,
                    'experience_level' => $request->experience_level,
                    'education_requirement' => $request->education_requirement,
                    'employment_type' => $request->employment_type,
                    'deadline' => $request->deadline,
                    'status' => $request->status ?? 0,
                    'created_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', 'Job Opening created successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $locations = Location::all();
                return view('admin.career.create', compact('locations'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function showApplication($id)
    {
        if(!checkPermission('view_job_application'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $applications = Application::where('opening_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        // dd($applications);
        return view('admin.career.show', compact('applications'));
    }

    public function editOpening(Request $request, $opening_id)
    {
        if(!checkPermission('edit_job_opening'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'title' => 'bail|required|string',
                    'description' => 'bail|nullable|string',
                    'role' => 'bail|nullable|string',
                    'location' => 'bail|nullable|string',
                    'department' => 'bail|required|string',
                    'experience_level' => 'bail|required|string',
                    'education_requirement' => 'bail|required|string',
                    'employment_type' => 'bail|required|string',
                    'deadline' => 'bail|string',
                    'status' => 'nullable|integer',
                ]);
                $opening = Opening::find($opening_id);

                $slug = Str::slug($request->department);
                
                $department = Department::firstOrCreate(
                ['name' => $request->department],
                [
                    'name' => $request->department,
                    'slug' => $slug
                ]
            );

                $opening->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'role' => $request->role,
                    'location_id' => $request->location,
                    'department_id' => $department->id,
                    'experience_level' => $request->experience_level,
                    'education_requirement' => $request->education_requirement,
                    'employment_type' => $request->employment_type,
                    'deadline' => $request->deadline,
                    'status' => $request->status ?? 0,
                    'last_edited_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', 'Job Opening updated successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $locations = Location::all();
                $opening = Opening::find($opening_id);
                return view('admin.career.edit', compact('locations', 'opening'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}

