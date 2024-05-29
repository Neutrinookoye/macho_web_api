<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BlogController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_blogs'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $blogs = Blog::orderBy('created_at', 'DESC')->get();
        foreach($blogs as $blog)
        {
            $category_id = $blog->category_id;
            $category = Category::find($category_id);
            $blog["category_name"] = $category->name;
        }
        // dd($blogs);
        return view('admin.blog.index', compact('blogs'))   ;
    }   

    public function createBlog(Request $request)
    {
        if(!checkPermission('create_blog'))
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
                'tags' => 'nullable|string' // validate tags as a string
            ]);

            $slug = Str::slug($request->title);
            $checkblog = Blog::where('slug', $slug)->first();
            if($checkblog)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already created this Blog.');
            }

            if ($request->is_featured) {
                $featuredBlogsCount = Blog::where('is_featured', 1)->count();
                if ($featuredBlogsCount >= 1) {
                    return redirect()->back()->with('danger', 'Sorry! Only 1 blogs can be featured at a time.');
                }
            }

            if($request->hasFile('featured_image'))
            {
                $uploadedFileUrl = Cloudinary::upload($request->file('featured_image')->getRealPath(),
                [
                    'folder' => 'blogs',
                ])->getSecurePath();
                // $featured_image_path = public_path("uploads/blogs/");

                // $featured_image = $request->file("featured_image");
                // $featured_image_name = Str::random(16).'.'.$featured_image->extension();

                // if($featured_image->move($featured_image_path, $featured_image_name))
                // {
                //     $featured_image_name = $featured_image_name;
                // }
            }else{
                $uploadedFileUrl = null;
            }

            $blog = Blog::create([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'category_id' => $request->category,
                'slug' => $slug,
                'content' => $request->content,
                'author' => $request->author,
                'publication_date' => $request->publication_date,
                'featured_image' => $uploadedFileUrl,
                'status' => $request->status ?? 0,
                'is_featured' => $request->is_featured ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            if ($request->tags) {
                $tagNames = explode(',', $request->tags);
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tagName = trim($tagName);
                    if (!empty($tagName)) {
                        $tag = Tag::firstOrCreate(['name' => $tagName]);
                        $tagIds[] = $tag->id;
                    }
                }
                $blog->tags()->sync($tagIds);
            }

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
        if($request->isMethod('patch'))
        {
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

                $slug = Str::slug($request->title);

                $checkblog = Blog::where('slug', $slug)->where('id', '!=', $blog_id)->first();
                if($checkblog)
                {
                    return redirect()->back()->with('danger', 'Sorry! A blog already exists with this title.');
                }

                if ($request->is_featured) {
                    $featuredBlogsCount = Blog::where('is_featured', 1)->count();
                    if ($featuredBlogsCount >= 1) {
                        return redirect()->back()->with('danger', 'Sorry! Only 1 blog can be featured at a time.');
                    }
                }

                $blog = Blog::find($blog_id);

                if($request->hasFile('featured_image'))
                {
                    $uploadedFileUrl = Cloudinary::upload($request->file('featured_image')->getRealPath(),
                    [
                        'folder' => 'blogs',
                    ])->getSecurePath();
                    // $featured_image_delete_path = public_path("uploads/blogs/" . $blog->featured_image);
                    // if (File::exists($featured_image_delete_path)) {
                    //     File::delete($featured_image_delete_path);
                    // }
                    // $featured_image_path = public_path("uploads/blogs/");

                    // $featured_image = $request->file("featured_image");
                    // $featured_image_name = Str::random(16).'.'.$featured_image->extension();

                    // if($featured_image->move($featured_image_path, $featured_image_name))
                    // {
                    //     $featured_image_name = $featured_image_name;
                    // }
                }else{
                    $uploadedFileUrl = $blog->featured_image;
                }

                $blog->update([
                    'title' => $request->title,
                    'sub_title' => $request->sub_title,
                    'slug' => $slug,
                    'category_id' => $request->category,
                    'content' => $request->content,
                    'author' => $request->author,
                    'publication_date' => $request->publication_date,
                    'featured_image' => $uploadedFileUrl,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'last_edited_by' => auth()->user()->id,
                ]);

                if ($request->tags) {
                    $tagNames = explode(',', $request->tags);
                    $tagIds = [];
                    foreach ($tagNames as $tagName) {
                        $tagName = trim($tagName);
                        if (!empty($tagName)) {
                            $tag = Tag::firstOrCreate(['name' => $tagName]);
                            $tagIds[] = $tag->id;
                        }
                    }
                    $blog->tags()->sync($tagIds);
                }

                return redirect()->back()->with('success', 'Blog updated successfully');

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
                $categories = Category::where('type', 'blog')->get();
                $blog = Blog::find($blog_id);
                // dd($blog);
                return view('admin.blog.edit', compact('categories', 'blog'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    
    }
}
