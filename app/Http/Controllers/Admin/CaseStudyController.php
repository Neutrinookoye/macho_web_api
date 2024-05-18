<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Project;
use App\Models\Service;
use App\Models\Location;
use App\Models\CaseStudy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CaseStudyController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_case_studies'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $casestudies = CaseStudy::orderBy('created_at', 'DESC')->get();
        // dd($casestudies);
        return view('admin.casestudies.index', compact('casestudies'))   ;
    }

    
    public function createCaseStudy(Request $request)
    {
        if(!checkPermission('create_case_study'))
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
                    'caption' => 'bail|required|string',
                    'project' => 'bail|required|string',
                    'service' => 'bail|required|string',
                    'brand' => 'bail|required|string',
                    'location' => 'bail|required|string',
                    'about' => 'bail|required',
                    'brief' => 'bail|required',
                    'challenge' => 'bail|required',
                    'approach' => 'bail|required',
                    'outcome' => 'bail|required',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                    'first_background_image' => 'bail|nullable',
                    'second_background_image' => 'bail|nullable',
                    'logo' => 'bail|nullable',
                    'document' => 'bail|nullable',
                    'created_by' => 'bail|integer',
                ]);
                // dd($request);

                $slug = Str::slug($request->name);

                $checkcasestudy = CaseStudy::where('slug', $slug)->first();
                if($checkcasestudy)
                {
                    return redirect()->back()->with('danger', 'Sorry! you have already added this case study.')->withInput();
                }
                // dd($request);

                if($request->hasFile('first_background_image'))
                {
                    $background_image_path = public_path("uploads/case_study/backgrounds");

                    $first_background = $request->file("first_background_image");
                    $first_background_name = Str::random(16).'.'.$first_background->extension();

                    if($first_background->move($background_image_path, $first_background_name))
                    {
                        $first_background = $first_background_name;
                    }
                }else{
                    $first_background = null;
                }   

                if($request->hasFile('second_background_image'))
                {
                    $background_image_path = public_path("uploads/case_study/backgrounds");

                    $second_background = $request->file("second_background_image");
                    $second_background_name = Str::random(16).'.'.$second_background->extension();

                    if($second_background->move($background_image_path, $second_background_name))
                    {
                        $second_background = $second_background_name;
                    }
                }else{
                    $second_background = null;
                }

                if($request->hasFile('logo'))
                {
                    $logo_path = public_path("uploads/case_study/logos");

                    $logo = $request->file("logo");
                    $logo_name = Str::random(16).'.'.$logo->extension();

                    if($logo->move($logo_path, $logo_name))
                    {
                        $logo = $logo_name;
                    }
                }else{
                    $logo = null;
                }

                if($request->hasFile('document'))
                {
                    $document_path = public_path("uploads/case_study/document");

                    $document = $request->file("document");
                    $document_name = Str::random(16).'.'.$document->extension();

                    if($document->move($document_path, $document_name))
                    {
                        $document = $document_name;
                    }
                }else{
                    $document = null;
                }
                // dd($request);

                $casestudy = CaseStudy::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'caption' => $request->caption,
                    'project_id' => $request->project,
                    'service_id' => $request->service,
                    'brand_id' => $request->brand,
                    'location_id' => $request->location,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $first_background,
                    'page_bg2' => $second_background,
                    'logo' => $logo,
                    'document' => $document,
                    'created_by' => auth()->user()->id,
                ]);
                // dd($casestudy);

                return redirect()->back()->with('success', 'Case Study created successfully');

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
                $projects = Project::all();
                $services = Service::all();
                $locations = Location::all();
                return view('admin.casestudies.create', compact('brands', 'services', 'locations', 'projects'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editCaseStudy(Request $request, $casestudy_id)
    {
        if(!checkPermission('edit_case_study'))
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
                    'caption' => 'bail|required|string',
                    'service' => 'bail|required|string',
                    'brand' => 'bail|required|string',
                    'location' => 'bail|required|string',
                    'about' => 'bail|required',
                    'brief' => 'bail|required',
                    'challenge' => 'bail|required',
                    'approach' => 'bail|required',
                    'outcome' => 'bail|required',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                    'first_background_image' => 'bail|nullable',
                    'second_background_image' => 'bail|nullable',
                    'logo' => 'bail|nullable',
                    'document' => 'bail|nullable',
                    'edited_by' => 'bail|integer',
                ]);
                // dd($request);

                $slug = Str::slug($request->name);

                $checkcasestudy = CaseStudy::where('slug', $slug)->where('id', '!=', $casestudy_id)->first();
                if($checkcasestudy)
                {
                    return redirect()->back()->with('danger', 'Sorry! you have already added this case study.')->withInput();
                }
                // dd($request);

                $casestudy = CaseStudy::find($casestudy_id);

                if($request->hasFile('first_background_image'))
                {
                    $background_image_path = public_path("uploads/case_study/backgrounds");

                    $first_background = $request->file("first_background_image");
                    $first_background_name = Str::random(16).'.'.$first_background->extension();

                    if($first_background->move($background_image_path, $first_background_name))
                    {
                        $first_background = $first_background_name;
                    }
                }else{
                    $first_background = $casestudy->first_background;
                }

                if($request->hasFile('second_background_image'))
                {
                    $background_image_path = public_path("uploads/case_study/backgrounds");

                    $second_background = $request->file("second_background_image");
                    $second_background_name = Str::random(16).'.'.$second_background->extension();

                    if($second_background->move($background_image_path, $second_background_name))
                    {
                        $second_background = $second_background_name;
                    }
                }else{
                    $second_background = $casestudy->second_background;
                }

                if($request->hasFile('logo'))
                {
                    $logo_path = public_path("uploads/case_study/logos");

                    $logo = $request->file("logo");
                    $logo_name = Str::random(16).'.'.$logo->extension();

                    if($logo->move($logo_path, $logo_name))
                    {
                        $logo = $logo_name;
                    }
                }else{
                    $logo = $casestudy->logo;
                }

                if($request->hasFile('document'))
                {
                    $document_path = public_path("uploads/case_study/document");

                    $document = $request->file("document");
                    $document_name = Str::random(16).'.'.$document->extension();

                    if($document->move($document_path, $document_name))
                    {
                        $document = $document_name;
                    }
                }else{
                    $document = $casestudy->document;
                }
                // dd($request);

                $casestudy->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'caption' => $request->caption,
                    'project_id' => $request->project,
                    'service_id' => $request->service,
                    'brand_id' => $request->brand,
                    'location_id' => $request->location,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $first_background,
                    'page_bg2' => $second_background,
                    'logo' => $logo,
                    'document' => $document,
                    'last_edited_by' => auth()->user()->id,
                ]);
                // dd($casestudy);

                return redirect()->back()->with('success', 'Case study edited successfully');

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
                $projects = Project::all();
                $services = Service::all();
                $locations = Location::all();
                $casestudy = CaseStudy::find($casestudy_id);
                return view('admin.casestudies.edit', compact('brands', 'services', 'locations', 'projects', 'casestudy'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

}
