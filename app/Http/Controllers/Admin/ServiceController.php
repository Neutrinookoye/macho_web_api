<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
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
                'image' => 'bail|required',
            ]);

            $slug = Str::slug($request->name);

            $service = Service::where('slug', $slug)->first();
            if($service)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this service');
            }

            if($request->hasFile('image'))
            {
                $bg_image_path = public_path("uploads/services/");

                $bg_image = $request->file("image");
                $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                if($bg_image->move($bg_image_path, $bg_image_name))
                {
                    $bg_image_name = $bg_image_name;
                }
            }else{
                $bg_image_name = null;
            }
            
            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'image' => $bg_image_name,
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
                'image' => 'nullable',
            ]);

            $slug = Str::slug($request->name);

            $service = Service::where('slug', $slug)->where('id', '!=', $service_id)->first();
            if($service)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this Service');
            }

            $service = Service::find($service_id);

            if($request->hasFile('image'))
            {

                $image_delete_path = public_path("uploads/services/" . $service->bg_image);
                if (File::exists($image_delete_path)) {
                    File::delete($image_delete_path);
                }
                $bg_image_path = public_path("uploads/services/");

                $bg_image = $request->file("image");
                $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                if($bg_image->move($bg_image_path, $bg_image_name))
                {
                    $bg_image_name = $bg_image_name;
                }
            }else{
                $bg_image_name = $service->brand_image;
            }

            // dd($service);

            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'image' => $bg_image_name,
            ]);

            // dd($service);

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
