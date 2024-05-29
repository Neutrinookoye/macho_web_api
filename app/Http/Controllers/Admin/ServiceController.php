<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ServiceController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_services'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $services = Service::orderBy('created_at', 'DESC')->get();
        // dd($services);
        return view('admin.service.index', compact('services'));
    }

    public function createService(Request $request)
    {
        if(!checkPermission('create_service'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
                'image' => 'bail|required',
                'icon' => 'bail|required',
            ]);

            $slug = Str::slug($request->name);

            $service = Service::where('slug', $slug)->first();
            if($service)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this service');
            }

            if($request->hasFile('image'))
            {
                $imageUrl = Cloudinary::upload($request->file('image')->getRealPath(),
                [
                    'folder' => 'services/images',
                ])->getSecurePath();
                // $bg_image_path = public_path("uploads/services/images");

                // $bg_image = $request->file("image");
                // $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                // if($bg_image->move($bg_image_path, $bg_image_name))
                // {
                //     $bg_image_name = $bg_image_name;
                // }
            }else{
                $imageUrl = null;
            }
            if($request->hasFile('icon'))
            {
                $iconUrl = Cloudinary::upload($request->file('icon')->getRealPath(),
                [
                    'folder' => 'services/icons',
                ])->getSecurePath();
                // $icon_path = public_path("uploads/services/icons");

                // $icon = $request->file("icon");
                // $icon_name = Str::random(16).'.'.$icon->extension();

                // if($icon->move($icon_path, $icon_name))
                // {
                //     $icon_name = $icon_name;
                // }
            }else{
                $iconUrl = null;
            }
            
            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'image' => $imageUrl,
                'icon' => $iconUrl,
                // 'created_by' => auth()->user()->id,
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
        if(!checkPermission('edit_service'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
                'image' => 'nullable',
                'icon' => 'nullable',
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
                $imageUrl = Cloudinary::upload($request->file('image')->getRealPath(),
                [
                    'folder' => 'services/images',
                ])->getSecurePath();
                // $image_delete_path = public_path("uploads/services/images" . $service->image);
                // if (File::exists($image_delete_path)) {
                //     File::delete($image_delete_path);
                // }
                // $bg_image_path = public_path("uploads/services/images");

                // $bg_image = $request->file("image");
                // $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                // if($bg_image->move($bg_image_path, $bg_image_name))
                // {
                //     $bg_image_name = $bg_image_name;
                // }
            }else{
                $imageUrl = $service->image;
            }

            if($request->hasFile('icon'))
            {
                $iconUrl = Cloudinary::upload($request->file('icon')->getRealPath(),
                [
                    'folder' => 'services/images',
                ])->getSecurePath();
                // $image_delete_path = public_path("uploads/services/icons" . $service->icon);
                // if (File::exists($image_delete_path)) {
                //     File::delete($image_delete_path);
                // }
                // $icon_path = public_path("uploads/services/icons");

                // $icon = $request->file("icon");
                // $icon_name = Str::random(16).'.'.$icon->extension();

                // if($icon->move($icon_path, $icon_name))
                // {
                //     $icon_name = $icon_name;
                // }
            }else{
                $iconUrl = $service->icon;
            }

            // dd($service);

            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'image' => $imageUrl,
                'icon' => $iconUrl,
                // 'last_edited_by' => auth()->user()->id,
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
