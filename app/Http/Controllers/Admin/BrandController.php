<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_brands'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        // dd($brands);   
        return view('admin.brand.index', compact('brands'));
    }

    public function createBrand(Request $request)
    {
        if(!checkPermission('create_brand'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'bail|required|string',
                'status' => 'nullable|integer',
                'description' => 'nullable|string',
                'brand_image' => 'bail|required',
            ]);
            
            $slug = Str::slug($request->name);
            $ref = strtoupper(Str::random(20));

            $checkbrand = Brand::where('slug', $slug)->first();
            if($checkbrand)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already added this brand.');
            }

            // Log::info($seocontent);
            // dd($request->content);
            if($request->hasFile('brand_image'))
            {
                $uploadedFileUrl = Cloudinary::upload($request->file('brand_image')->getRealPath(),
                [
                    'folder' => 'brands',
                ])->getSecurePath();
            //     $bg_image_path = public_path("uploads/brands/");

            //     $bg_image = $request->file("brand_image");
            //     $bg_image_name = Str::random(16).'.'.$bg_image->extension();

            //     if($bg_image->move($bg_image_path, $bg_image_name))
            //     {
            //         $bg_image_name = $bg_image_name;
            //     }
            }else{
                $uploadedFileUrl = null;
            }

            $brand = Brand::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'status' => $request->status ?? 0,
                'brand_image' => $uploadedFileUrl,
                'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Brand created successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editBrand(Request $request, $brand_id)
    {
        if(!checkPermission('edit_brand'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
                $this->validate($request, [
                'name' => 'bail|required|string',
                'status' => 'nullable|integer',
                'description' => 'nullable|string',
                'brand_image' => 'nullable',
            ]);
            
            $slug = Str::slug($request->name);

            $checkbrand = Brand::where('slug', $slug)->where('id', '!=', $brand_id)->first();;
            if($checkbrand)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
            }

            // Log::info($seocontent);
            // dd($request->content);
            $brand = Brand::find($brand_id);
            // dd($banner);

            if($request->hasFile('brand_image'))
            {
                $uploadedFileUrl = Cloudinary::upload($request->file('brand_image')->getRealPath(),
                [
                    'folder' => 'brands',
                ])->getSecurePath();
                // $image_delete_path = public_path("uploads/brands/" . $brand->bg_image);
                // if (File::exists($image_delete_path)) {
                //     File::delete($image_delete_path);
                // }
                // $bg_image_path = public_path("uploads/brands/");

                // $bg_image = $request->file("brand_image");
                // $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                // if($bg_image->move($bg_image_path, $bg_image_name))
                // {
                //     $bg_image_name = $bg_image_name;
                // }
            }else{
                $uploadedFileUrl = $brand->brand_image;
            }

            $brand->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'status' => $request->status ?? 0,
                'brand_image' => $uploadedFileUrl,
                'last_edited_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Brand updated successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
