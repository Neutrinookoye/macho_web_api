<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_locations'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $locations = Location::orderBy('created_at', 'DESC')->where('staatus', 1)->get();
        return view('admin.location.index', compact('openings'));
    }

    public function createLocation(Request $request)
    {
        if(!checkPermission('create_locations'))
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

                $opening = Opening::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'role' => $request->role,
                    'location_id' => $request->location,
                    'department' => $request->department,
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
                return view('admin.location.create', compact('locations'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
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

                $opening->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'role' => $request->role,
                    'location_id' => $request->location,
                    'department' => $request->department,
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
