<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $categories = Category::where('type', $request->type)->orderBy('created_at', 'DESC')->get();

            $type = $request->type ?? 'All';
            return view('admin.category.index', compact('categories', 'type'));

        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
    
        }
    }

    public function createCategory(Request $request)
    {
        try
        {
            $request->validate([
                'name' => 'bail|required|string',
                'description' => 'bail|nullable|string',
                'status' => 'nullable|integer',
                'type' => 'bail|required|string',
            ]);

            $slug = Str::slug($request->name);

            $category = Category::where('slug', $slug)->first();
            if($category)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this forum category');
            }

            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'type' => $request->type,
                // 'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Category added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editCategory(Request $request, $category_id)
    {
        try
        {
            // dd($request->all());
            $request->validate([
                'name' => 'bail|required|string',
                'description' => 'bail|nullable|string',
                'status' => 'nullable|integer',
                'type' => 'bail|required|string',
            ]);

            $slug = Str::slug($request->name);

            $category = Category::find($category_id);

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                'type' => $request->type,
                // 'last_edited_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Category added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
