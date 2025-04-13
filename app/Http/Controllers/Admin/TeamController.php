<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $teamMembers = Team::orderBy('created_at', 'DESC')->get();

            return view('admin.team.index', compact('teamMembers'));

        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
    
        }
    }

    public function createTeam(Request $request)
    {
        try
        {
            // dd($request);   
            $request->validate([
                'name' => 'bail|required|string',
                'role' => 'bail|required|string',
                'department' => 'bail|required|string',
                'about' => 'bail|nullable|string',
                'image' => 'bail|nullable',
                'status' => 'nullable|integer',
            ]);
            // dd($request);

            $slug = Str::slug($request->name);

            $team = Team::where('slug', $slug)->first();
            if($team)
            {
                return redirect()->back()->with('danger', 'Sorry! you have already added this team member');
            }

            if($request->hasFile('image'))
            {
                $image_path = public_path("uploads/teams/");

                $image = $request->file("image");
                $image_name = Str::random(16).'.'.$image->extension();

                $image->move($image_path, $image_name);
                $imageUrl = asset('uploads/teams/' . $image_name);
            }else{
                $imageUrl = null;
            }

            $team = Team::create([
                'name' => $request->name,
                'role' => $request->role,
                'department' => $request->department,
                'about' => $request->about,
                'slug' => $slug,
                'image' => $imageUrl,
                'status' => $request->status ?? 0,
                // 'created_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Team member added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function editTeam(Request $request, $team_id)
    {
        try
        {
            $request->validate([
                'name' => 'bail|required|string',
                'role' => 'bail|required|string',
                'department' => 'bail|required|string',
                'about' => 'bail|nullable|string',
                'image' => 'bail|nullable|string',
                'status' => 'nullable|integer',
            ]);

            $slug = Str::slug($request->name);

            $checkteam = Team::where('slug', $slug)->where('id', '!=', $team_id)->first();
            if($checkteam)
            {
                return redirect()->back()->with('danger', 'Sorry! A team member already exists with this name.');
            }

            $team = Team::find($team_id);

            if($request->hasFile('image'))
            {
                $image_path = public_path("uploads/teams/");

                $image = $request->file("image");
                $image_name = Str::random(16).'.'.$image->extension();

                $image->move($image_path, $image_name);
                $imageUrl = asset('uploads/teams/' . $image_name);
            }else{
                $imageUrl = $team->image;
            }

            $team->update([
                'name' => $request->name,
                'role' => $request->role,
                'department' => $request->department,
                'about' => $request->about,
                'slug' => $slug,
                'image' => $imageUrl,
                'status' => $request->status ?? 0,
                // 'last_edited_by' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Team member added successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
