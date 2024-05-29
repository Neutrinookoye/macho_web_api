<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Award;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AwardController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_awards'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $awards = Award::orderBy('created_at', 'DESC')->get();
        foreach($awards as $award)
        {
            $category_id = $award->category_id;
            $category = Category::find($category_id);
            $award["category_name"] = $category->name;
        }
        // dd($blogs);
        return view('admin.award.index', compact('awards'))   ;
    }   

    public function createAward(Request $request)
    {
        if(!checkPermission('create_award'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            // dd($request);
                $this->validate($request, [
                'name' => 'bail|required|string',
                'description' => 'bail|nullable|string',
                'category' => 'bail|integer|string',
                'year' => 'bail|required|string',
                'issuer' => 'bail|required|string',
                'award_image' => 'bail|nullable|image',
                'status' => 'nullable|integer',
                'is_featured' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->name);
            $checkaward = Award::where('slug', $slug)->first();
            if($checkaward)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already created this Award.');
            }

            if ($request->is_featured) {
                $featuredAwardsCount = Award::where('is_featured', 1)->count();
                if ($featuredAwardsCount >= 1) {
                    return redirect()->back()->with('danger', 'Sorry! Only 1 awards can be featured at a time.');
                }
            }

            if($request->hasFile('award_image'))
            {
                $uploadedFileUrl = Cloudinary::upload($request->file('award_image')->getRealPath(),
                [
                    'folder' => 'awards',
                ])->getSecurePath();
                // $award_image_path = public_path("uploads/awards/");

                // $award_image = $request->file("award_image");
                // $award_image_name = Str::random(16).'.'.$award_image->extension();

                // if($award_image->move($award_image_path, $award_image_name))
                // {
                //     $award_image_name = $award_image_name;
                // }
            }else{
                $uploadedFileUrl = null;
            }

            $award = Award::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'category_id' => $request->category,
                'year' => $request->year,
                'issuer' => $request->issuer,
                'image' => $uploadedFileUrl,
                'status' => $request->status ?? 0,
                'is_featured' => $request->is_featured ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Award created successfully');
        }else{
            try
            {
                $categories = Category::where('type', 'award')->get();
                return view('admin.award.create', compact('categories'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editAward(Request $request, $award_id)
    {
        if(!checkPermission('edit_award'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request);
                $this->validate($request, [
                    'name' => 'bail|required|string',
                    'description' => 'bail|nullable|string',
                    'category' => 'bail|integer|string',
                    'year' => 'bail|required|string',
                    'issuer' => 'bail|required|string',
                    'award_image' => 'bail|nullable|image',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                ]);

                $slug = Str::slug($request->name);

                $checkaward = Award::where('slug', $slug)->where('id', '!=', $award_id)->first();
                if($checkaward)
                {
                    return redirect()->back()->with('danger', 'Sorry! An award alredy exists with this name.');
                }

                if ($request->is_featured) {
                    $featuredAwardsCount = Award::where('is_featured', 1)->count();
                    if ($featuredAwardsCount >= 1) {
                        return redirect()->back()->with('danger', 'Sorry! Only 1 award can be featured at a time.');
                    }
                }

                $award = Award::find($award_id);
                // dd($award);

                if($request->hasFile('award_image'))
                {
                    $uploadedFileUrl = Cloudinary::upload($request->file('award_image')->getRealPath(),
                    [
                        'folder' => 'awards',
                    ])->getSecurePath();
                    // $award_image_delete_path = public_path("uploads/awards/" . $award->award_image);
                    // if (File::exists($award_image_delete_path)) {
                    //     File::delete($award_image_delete_path);
                    // }
                    // $award_image_path = public_path("uploads/awards/");

                    // $award_image = $request->file("award_image");
                    // $award_image_name = Str::random(16).'.'.$award_image->extension();

                    // if($award_image->move($award_image_path, $award_image_name))
                    // {
                    //     $award_image_name = $award_image_name;
                    // }
                }else{
                    $uploadedFileUrl = $award->image;
                }

                $award->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'year' => $request->year,
                    'issuer' => $request->issuer,
                    'image' => $uploadedFileUrl,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'last_edited_by' => auth()->user()->id,
                ]);

                return redirect()->back()->with('success', 'Award updated successfully');

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
                // $categories = Category::all();
                $categories = Category::where('type', 'award')->get();
                $award = Award::find($award_id);
                // dd($award);
                return view('admin.award.edit', compact('categories', 'award'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    
    }
}
