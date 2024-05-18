<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Brand;
use App\Models\Project;
use App\Models\Service;
use App\Models\Location;
use Illuminate\Support\Str;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Projectdata;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_projects'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $projects = Project::orderBy('created_at', 'DESC')->get();
        foreach($projects as $project)
        {
            $user_id = $project->created_by;
            $user = User::find($user_id);
            $project->created_by_name = $user->name;
        }
        // dd($projects);
        return view('admin.project.index', compact('projects'))   ;
    }

    public function createProject(Request $request)
    {
        if(!checkPermission('create_project'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'service' => 'bail|required|string',
                    'brand' => 'bail|required|string',
                    'location' => 'bail|required|string',
                    'short_description' => 'bail|nullable',
                    'description' => 'bail|required',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                    'thumb_image' => 'bail|required',
                    'images' => 'bail|array',
                    'project_data' => 'bail|required|array|min:1',
                    'project_data.*.data_name' => 'bail|required',
                    'project_data.*.data_value' => 'bail|required|string',
                    'created_by' => 'bail|integer',
                ]);
                // dd($request);

                $slug = Str::slug($request->name);

                $checkproject = Project::where('slug', $slug)->first();
                if($checkproject)
                {
                    return redirect()->back()->with('danger', 'Sorry! you have already added this project.')->withInput();
                }

                if($request->hasFile('thumb_image'))
                {
                    $thumb_image_path = public_path("uploads/projects/");

                    $thumb_image = $request->file("thumb_image");
                    $thumb_image_name = Str::random(16).'.'.$thumb_image->extension();

                    if($thumb_image->move($thumb_image_path, $thumb_image_name))
                    {
                        $thumb_image_name = $thumb_image_name;
                    }
                }else{
                    $thumb_image_name = null;
                }

                $project = Project::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'service_id' => $request->service,
                    'brand_id' => $request->brand,
                    'location_id' => $request->location,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'thumb_image' => $thumb_image_name,
                    'created_by' => auth()->user()->id,
                ]);
                // dd($project);
                // dd($request->project_data);

                foreach($request->project_data as $projectData)
                {
                    $projectdata = Projectdata::create([
                        'project_id' => $project->id,
                        'data_name' => $projectData['data_name'],
                        'data_value' => $projectData['data_value'],
                    ]);
                    // dd($projectdata);
                }

                foreach($request->images as $k => $image)
                {

                    $image_path = public_path("uploads/projects/");

                    $image = $request->file('images')[$k];
                    $image_name = Str::random(16).'_'.time().'.'.$image->extension();

                    if($image->move($image_path, $image_name))
                    {
                        $file = ProjectImage::create([
                            'project_id' => $project->id,
                            'image' => $image_name,
                        ]);
                    }

                }

                return redirect()->back()->with('success', 'Project created successfully');

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
                $brands = Brand::all();
                $services = Service::all();
                $locations = Location::all();
                return view('admin.project.create', compact('brands', 'services', 'locations'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editProject(Request $request, $project_id)
    {
        if(!checkPermission('edit_project'))
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
                    'service' => 'bail|required|string',
                    'brand' => 'bail|required|string',
                    'location' => 'bail|required|string',
                    'short_description' => 'bail|nullable',
                    'description' => 'bail|required',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                    'thumb_image' => 'bail|nullable',
                    'images' => 'bail|nullable|array',
                    'project_data' => 'bail|required|array|min:1',
                    'project_data.*.data_name' => 'bail|required',
                    'project_data.*.data_value' => 'bail|required|string',
                    'edited_by' => 'bail|integer',

                ]);

                $slug = Str::slug($request->name);

                $checkproject = Project::where('slug', $slug)->where('id', '!=', $project_id)->first();
                if($checkproject)
                {
                    return redirect()->back()->with('danger', 'Sorry! you have already added this project.')->withInput();
                }

                $project = Project::find($project_id);

                if($request->hasFile('thumb_image'))
                {
                    $thumb_image_path = public_path("uploads/projects/");

                    $thumb_image = $request->file("thumb_image");
                    $thumb_image_name = Str::random(16).'.'.$thumb_image->extension();

                    if($thumb_image->move($thumb_image_path, $thumb_image_name))
                    {
                        $thumb_image_name = $thumb_image_name;
                    }
                }else{
                    $thumb_image_name = $project->thumb_image;
                }

                $project->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'service_id' => $request->service,
                    'brand_id' => $request->brand,
                    'location_id' => $request->location,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'thumb_image' => $thumb_image_name,
                    'last_edited_by' => auth()->user()->id,
                ]);

                if (!empty($request->images)) {
                    foreach($request->images as $k => $image)
                    {

                        $image_path = public_path("uploads/projects/");

                        $image = $request->file('images')[$k];
                        $image_name = Str::random(16).'_'.time().'.'.$image->extension();

                        if($image->move($image_path, $image_name))
                        {
                            $file = ProjectImage::create([
                                'project_id' => $project->id,
                                'image' => $image_name,
                            ]);
                        }

                    }
                }   

                $existingProjectData = $project->projectdata->keyBy('id');

                // Track IDs of project data that need to be kept
                $dataToKeep = [];

                foreach ($request->project_data as $index => $data) {
                    $existingData = $existingProjectData->firstWhere('data_name', $data['data_name']);

                    if ($existingData) {
                        // Update existing data if value has changed
                        if ($existingData->data_value != $data['data_value']) {
                            $existingData->update([
                                'data_value' => $data['data_value'],
                            ]);
                        }

                        $dataToKeep[] = $existingData->id;
                    } else {
                        // Create new project data if not found in existing data
                        $newData = Projectdata::create([
                            'project_id' => $project->id,
                            'data_name' => $data['data_name'],
                            'data_value' => $data['data_value'],
                        ]);

                        $dataToKeep[] = $newData->id;
                    }
                }

                // Delete any project data that was not in the new input
                Projectdata::where('project_id', $project_id)->whereNotIn('id', $dataToKeep)->delete();

                return redirect()->back()->with('success', 'Project updated successfully');

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
                $brands = Brand::all();
                $services = Service::all();
                $locations = Location::all();
                $project = Project::find($project_id);
                $project_data = Projectdata::where('project_id', $project_id)->get();
                // dd($project_data);
                return view('admin.project.edit', compact('brands', 'services', 'locations', 'project', 'project_data'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function removeImage($project_id, $image_id)
    {
        // dd($project_id);
        // dd($image_id);
        $image = ProjectImage::where('project_id', $project_id)->where('id', $image_id)->first();
        $image_delete_path = public_path("uploads/projects/".$image->image);
        if(File::exists($image_delete_path)) {
            File::delete($image_delete_path);
        }
         
        $image->delete();
        return redirect()->back()->with('success', 'Project image deleted successfully');
    }
}
