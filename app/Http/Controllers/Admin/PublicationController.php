<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Publication;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PublicationController extends Controller
{
    //
    public function index()
    {
        $publications = Publication::orderBy('created_at', 'DESC')->get();
        foreach($publications as $publication)
        {
            $category_id = $publication->category_id;
            $category = Category::find($category_id);
            $publication["category_name"] = $category->name;
        }
        return view('admin.publication.index', compact('publications'))   ;
    }

    public function createPublication(Request $request)
    {
        if(!checkPermission('create_job_application'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'category' => 'bail|required|string',
                    'publication_date' => 'bail|required|date',
                    'title' => 'bail|required|string',
                    'description' => 'bail|nullable|string',
                    'thumb_image' => 'bail|required',
                    'publication_file' => 'bail|required',
                    'status' => 'nullable|integer',
                ]);

                if($request->hasFile('thumb_image'))
                {
                    $thumb_image_path = public_path("uploads/publication/");

                    $thumb_image = $request->file("thumb_image");
                    $thumb_image_name = Str::random(16).'.'.$thumb_image->extension();

                    if($thumb_image->move($thumb_image_path, $thumb_image_name))
                    {
                        $thumb_image_name = $thumb_image_name;
                    }
                }else{
                    $thumb_image_name = null;
                }

                if($request->hasFile('publication_file'))
                {
                    $publication_file_path = public_path("uploads/publication/");

                    $publication_file = $request->file("publication_file");
                    $publication_file_name = Str::random(16).'.'.$publication_file->extension();

                    if($publication_file->move($publication_file_path, $publication_file_name))
                    {
                        $publication_file_name = $publication_file_name;
                    }
                }else{
                    $publication_file_name = null;
                }

                $publication = Publication::create([
                    'category_id' => $request->category,
                    'publication_date' => $request->publication_date,
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'thumb_image' => $thumb_image_name,
                    'publication_file' => $publication_file_name,
                ]);

                return redirect()->back()->with('success', 'Publication created successfully');

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
                $categories = Category::where('type', 'publication')->get();
                return view('admin.publication.create', compact('categories'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editPublication(Request $request, $publication_id)
    {
        if(!checkPermission('create_job_application'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'category' => 'bail|required|string',
                    'publication_date' => 'bail|required|date',
                    'title' => 'bail|required|string',
                    'description' => 'bail|nullable|string',
                    'thumb_image' => 'bail|nullable',
                    'publication_file' => 'bail|nullable',
                    'status' => 'nullable|integer',
                ]);

                $publication = Publication::find($publication_id);

                if($request->hasFile('thumb_image'))
                {
                    $thumb_image_path = public_path("uploads/publication/");

                    $thumb_image = $request->file("thumb_image");
                    $thumb_image_name = Str::random(16).'.'.$thumb_image->extension();

                    if($thumb_image->move($thumb_image_path, $thumb_image_name))
                    {
                        $thumb_image_name = $thumb_image_name;
                    }
                }else{
                    $thumb_image_name = $publication->thumb_image;
                }

                if($request->hasFile('publication_file'))
                {
                    $publication_file_path = public_path("uploads/publication/");

                    $publication_file = $request->file("publication_file");
                    $publication_file_name = Str::random(16).'.'.$publication_file->extension();

                    if($publication_file->move($publication_file_path, $publication_file_name))
                    {
                        $publication_file_name = $publication_file_name;
                    }
                }else{
                    $publication_file_name = $publication->publication_file;
                }


                $publication->update([
                    'category_id' => $request->category,
                    'publication_date' => $request->publication_date,
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'thumb_image' => $thumb_image_name,
                    'publication_file' => $publication_file_name,
                ]);

                return redirect()->back()->with('success', 'Publication created successfully');

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
                $categories = Category::all();
                $publication = Publication::find($publication_id);
                return view('admin.publication.edit', compact('categories', 'publication'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
    

}
