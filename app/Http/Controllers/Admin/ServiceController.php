<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_brand'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $services = Service::orderBy('created_at', 'DESC')->get();
        // dd($services);
        return view('admin.service.index', compact('services'));
    }

    public function createService(Request $request)
    {
        try
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->name);

            $service = Service::where('slug', $slug)->first();
            if($service)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this service');
            }

            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
            ]);

            return redirect()->back()->with('success', 'Service created successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editService(Request $request, $service_id)
    {
        try
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->name);

            $service = Service::where('slug', $slug)->where('id', '!=', $service_id)->first();
            if($service)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this Service');
            }

            $service = Service::find($service_id);

            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
            ]);

            return redirect()->back()->with('success', 'Service updated successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
