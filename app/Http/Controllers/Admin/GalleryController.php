<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    //
    public function index()
    {
        $galleries = Gallery::get();

        // dd('Dashboard');
        return view('admin.gallery.index', compact('galleries'));
    }

    public function createGallery(Request $request)
    {
        if($request->isMethod('post'))
        {
            try
            {       
                $this->validate($request, [
                    'category' => 'bail|required|integer',
                    'title' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'is_featured'  => 'nullable|integer',
                    'description' => 'bail|required|string',
                    'gallery_images' => 'nullable',
                ]);

                $slug = Str::slug($request->title);

                $gal = Gallery::create([
                    // 'user_id' => $admin->id,
                    'category_id' => $request->category,
                    'title' => $request->title,
                    'slug' => $slug,
                    'description' => $request->description,
                    // 'last_edited_by' => $admin->id,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                ]);

                foreach($request->gallery_images as $k => $file)
                {

                    $image_path = public_path("uploads/galleries/");

                    $image = $request->file('gallery_images')[$k];
                    $image_name = Str::random(16).'_'.time().'.'.$image->extension();

                    if($image->move($image_path, $image_name))
                    {
                        $image_name = asset('uploads/galleries/'.$image_name);
                    }

                    $file = GalleryImage::create([
                        'gallery_id' => $gal->id,
                        'file_url' => $image_name,
                        'is_preview' => $k == 0 ? 1 : 0,
                    ]);
                }

                return redirect()->back()->with('success', 'Galleries created successfully');

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
                $categories = Category::where('type', 'gallery')->get();
                return view('admin.gallery.create', compact('categories'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editGallery(Request $request, $gallery_id)
    {
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request->all());
                $this->validate($request, [
                    'category' => 'bail|required|integer',
                    'title' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'is_featured'  => 'nullable|integer',
                    'description' => 'bail|required|string',
                    'gallery_images' => 'nullable',
                ]);

                $slug = Str::slug($request->title);
                $ref = strtoupper(Str::random(20));

                $seocontent = strip_tags(str_replace('<p>', ' ', $request->description));
                $seocontent = str_replace('&nbsp;', '', $seocontent);
                $seocontent = preg_replace('/\s+/', ' ', $seocontent);

                $gallery = Gallery::where('id', $gallery_id)->first();

                $gallery->update([
                    // 'user_id' => $admin->id,
                    'category_id' => $request->category,
                    'title' => $request->title,
                    'slug' => $slug,
                    'description' => $request->description,
                    // 'last_edited_by' => $admin->id,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                ]);

                if($request->hasFile('gallery_images'))
                {
                    foreach($request->gallery_images as $k => $file)
                    {

                        $image_path = public_path("uploads/galleries/");

                        $image = $request->file('gallery_images')[$k];
                        $image_name = Str::random(16).'_'.time().'.'.$image->extension();

                        if($image->move($image_path, $image_name))
                        {
                            $image_name = asset('/uploads/galleries/'.$image_name);
                        }

                        $file = GalleryImage::create([
                            'gallery_id' => $gallery->id,
                            'file_url' => $image_name,
                            // 'is_preview' => $k == 0 ? 1 : 0,
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Gallery edited successfully');

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
                $categories = Category::where('type', 'gallery')->get();
                $gallery = Gallery::find($gallery_id);
                // dd($gallery);
                return view('admin.gallery.edit', compact('gallery', 'categories'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function removeImage($gallery_id, $image_id)
    {
        $image = GalleryImage::where('gallery_id', $gallery_id)->where('id', $image_id)->first();
        $image_delete_path = public_path("uploads/gallery/".$image->image);
        if(File::exists($image_delete_path)) {
            File::delete($image_delete_path);
        }
         
        $image->delete();
        return redirect()->back()->with('success', 'Gallery image deleted successfully');
    }
}
