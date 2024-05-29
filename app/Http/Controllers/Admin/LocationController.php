<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_locations'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $locations = Location::orderBy('created_at', 'DESC')->get();
        return view('admin.location.index', compact('locations'));
    }

    public function createLocation(Request $request)
    {
        if(!checkPermission('create_location'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'company_name' => 'bail|required|string',
                    'address' => 'bail|required|string',
                    'email' => 'bail|required|string|email',
                    'phone_number' => 'bail|required|string',
                    'country_name' => 'bail|required|string',
                    'lat' => 'bail|required|string',
                    'lng' => 'bail|required|string',
                    'status' => 'nullable|integer',
                ]);

                $slug = Str::slug($request->country_name);

                $location = Location::create([
                    'name' => $request->country_name,
                    'company_name' => $request->company_name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'phone_number' => $request->phone_number,
                    'slug' => $slug,
                    'status' => $request->status ?? 0,
                    'created_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', 'Location created successfully');

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

    public function editLocation(Request $request, $location_id)
    {
        if(!checkPermission('edit_location'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'company_name' => 'bail|required|string',
                    'address' => 'bail|required|string',
                    'email' => 'bail|required|string|email',
                    'phone_number' => 'bail|required|string',
                    'country_name' => 'bail|required|string',
                    'lat' => 'bail|required|string',
                    'lng' => 'bail|required|string',
                    'status' => 'nullable|integer',
                ]);

                $slug = Str::slug($request->country_name);

                $checklocation = Location::where('slug', $slug)->where('id', '!=', $location_id)->first();
                if($checklocation)
                {
                    return redirect()->back()->with('danger', 'Sorry! A location already exists with this country name.');
                }

                $location = Location::find($location_id);

                $location->update([
                    'name' => $request->country_name,
                    'company_name' => $request->company_name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'phone_number' => $request->phone_number,
                    'slug' => $slug,
                    'status' => $request->status ?? 0,
                    'last_edited_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', 'Location updated successfully');

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
                $location = Location::find($location_id);
                return view('admin.location.edit', compact('location'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
