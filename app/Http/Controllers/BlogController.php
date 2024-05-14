<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    //
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'DESC')->get();
        foreach($blogs as $blog)
        {
            $category_id = $blog->category_id;
            $category = Category::find($category_id);
            $blog["category_name"] = $category->name;
        }
        dd($blogs);
        return view('admin.blog.index', compact('blogs'))   ;
    }   

    public function createBlog(Request $request)
    {
        if(!checkPermission('create_job_application'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            // dd($request);
                $this->validate($request, [
                'title' => 'bail|required|string',
                'sub_title' => 'bail|string',
                'category' => 'bail|integer|string',
                'content' => 'bail|required|string',
                'author' => 'bail|required|string',
                'publication_date' => 'bail|required|date',
                'featured_image' => 'bail|nullable|image',
                'status' => 'nullable|integer',
                'is_featured' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->title);
            $checkblog = Blog::where('slug', $slug)->first();
            if($checkblog)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already created this Blog.');
            }

            if($request->hasFile('featured_image'))
            {
                $featured_image_path = public_path("uploads/blog/");

                $featured_image = $request->file("featured_image");
                $featured_image_name = Str::random(16).'.'.$featured_image->extension();

                if($featured_image->move($featured_image_path, $featured_image_name))
                {
                    $featured_image_name = $featured_image_name;
                }
            }else{
                $featured_image_name = null;
            }

            $blog = Blog::create([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'category_id' => $request->category,
                'slug' => $slug,
                'content' => $request->content,
                'author' => $request->author,
                'publication_date' => $request->publication_date,
                'featured_image' => $featured_image_name,
                'status' => $request->status ?? 0,
                'is_featured' => $request->is_featured ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Blog created successfully');
        }else{
            try
            {
                $categories = Category::where('type', 'blog')->get();
                return view('admin.blog.create', compact('categories'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editBlog(Request $request, $blog_id)
    {
        if(!checkPermission('edit_blog'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            // dd($request);
            $this->validate($request, [
                'title' => 'bail|required|string',
                'sub_title' => 'bail|string',
                'category' => 'bail|integer|string',
                'content' => 'bail|required|string',
                'author' => 'bail|required|string',
                'publication_date' => 'bail|required|date',
                'featured_image' => 'bail|nullable|image',
                'status' => 'nullable|integer',
                'is_featured' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->name);

            $blog = Blog::find($blog_id);
            dd($blog);

            if($request->hasFile('featured_image'))
            {

                $featured_image_delete_path = public_path("uploads/blog/" . $blog->featured_image);
                if (File::exists($featured_image_delete_path)) {
                    File::delete($featured_image_delete_path);
                }
                $featured_image_path = public_path("uploads/blog/");

                $featured_image = $request->file("featured_image");
                $featured_image_name = Str::random(16).'.'.$featured_image->extension();

                if($featured_image->move($featured_image_path, $featured_image_name))
                {
                    $featured_image_name = $featured_image_name;
                }
            }else{
                $featured_image_name = $blog->featured_image;
            }

            $blog->update([
                'title' => $request->title,
                'sub_title' => 'bail|string',
                'slug' => $slug,
                'category' => 'bail|integer|string',
                'content' => 'bail|required|string',
                'author' => 'bail|required|string',
                'publication_date' => 'bail|required|date',
                'featured_image' => 'bail|nullable|image',
                'status' => 'nullable|integer',
                'is_featured' => 'nullable|integer',
                'last_edited_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Product updated successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
