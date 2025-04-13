<?php

namespace App\Http\Controllers\Admin;

use App\Models\Achievement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AchievementController extends Controller
{
    //
        public function index(Request $request)
    {
        try{
            $achievements = Achievement::orderBy('created_at', 'DESC')->get();

            return view('admin.achievement.index', compact('achievements'));

        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
    
        }
    }

    public function createAchievement(Request $request)
    {
        try
        {
            // dd($request);   
            $request->validate([
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
            ]);
            // dd($request);

            $slug = Str::slug($request->title);

            $achievements = Achievement::where('slug', $slug)->first();
            if($achievements)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this achievement');
            }

            $achievement = Achievement::create([
                'title' => $request->title,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                // 'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Testimonial added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editAchievement(Request $request, $achievement_id)
    {
        try
        {
            // dd($request);
            $request->validate([
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'status' => 'nullable|integer',
            ]);
            // dd($request);

            $slug = Str::slug($request->title);

            $checkachievement = Achievement::where('slug', $slug)->where('id', '!=', $achievement_id)->first();
            if($checkachievement)
            {
                return redirect()->back()->with('danger', 'Sorry! An achievement already exists with this name.');
            }

            $achievement = Achievement::find($achievement_id);

            $achievement->update([
                'title' => $request->title,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status ?? 0,
                // 'last_edited_by' => auth()->user()->id,
            ]);
            // dd($achievement);

            return redirect()->back()->with('success', 'Achievement added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
