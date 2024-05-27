<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Project;
use App\Models\Service;
use App\Models\Location;
use App\Models\CaseStudy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CaseStudyImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
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
                    'year' => 'bail|required|integer',
                    'about' => 'bail|required',
                    'brief' => 'bail|required',
                    'challenge' => 'bail|required',
                    'approach' => 'bail|required',
                    'outcome' => 'bail|required',
                    'video_url' => 'bail|string',
                    'status' => 'nullable|integer',
                    'is_featured' => 'nullable|integer',
                    'images' => 'bail|array',
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

                if ($request->is_featured) {
                    $featuredCaseStudyCount = CaseStudy::where('is_featured', 1)->count();
                    if ($featuredCaseStudyCount >= 3) {
                        return redirect()->back()->with('danger', 'Sorry! Only 3 case studies can be featured at a time.');
                    }
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
                    'year' => $request->year,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'video_url' => $request->video_url,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $first_background,
                    'page_bg2' => $second_background,
                    'logo' => $logo,
                    'document' => $document,
                    'created_by' => auth()->user()->id,
                ]);

                if (is_array($request->images)) {
                    $image_path = public_path("uploads/case_study/images");
                    foreach ($request->file('images') as $image) {
                        $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                        if ($image->move($image_path, $image_name)) {
                            CaseStudyImage::create([
                                'case_study_id' => $casestudy->id,
                                'image' => $image_name,
                            ]);
                        }
                    }
                }
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
                $brands = Brand::where('status', 1)->get();
                $projects = Project::where('status', 1)->get();
                $services = Service::where('status', 1)->get();
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
                    'project' => 'bail|required|string',
                    'service' => 'bail|required|string',
                    'brand' => 'bail|required|string',
                    'location' => 'bail|required|string',
                    'year' => 'bail|required|integer',
                    'about' => 'bail|required',
                    'brief' => 'bail|required',
                    'challenge' => 'bail|required',
                    'approach' => 'bail|required',
                    'outcome' => 'bail|required',
                    'video_url' => 'bail|string',
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
                // dd($casestudy);

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
                    $first_background = $casestudy->page_bg;
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
                    $second_background = $casestudy->page_bg2;
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
                    'year' => $request->year,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'video_url' => $request->video_url,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $first_background,
                    'page_bg2' => $second_background,
                    'logo' => $logo,
                    'document' => $document,
                    'last_edited_by' => auth()->user()->id,
                ]);

                if ($request->hasFile('images')) {
                    $currentImageCount = CaseStudyImage::where('case_study_id', $casestudy->id)->count();
                    $newImages = $request->file('images');
                    $totalImagesCount = $currentImageCount + count($newImages);
    
                    if ($totalImagesCount > 10) {
                        return redirect()->back()->with('danger', 'You can only upload up to 10 images for a project.')->withInput();
                    }
    
                    $image_path = public_path("uploads/case_study/images");
                    foreach ($newImages as $image) {
                        $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                        if ($image->move($image_path, $image_name)) {
                            CaseStudyImage::create([
                                'case_study_id' => $casestudy->id,
                                'image' => $image_name,
                            ]);
                        }
                    }
                }
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
                $brands = Brand::where('status', 1)->get();
                $projects = Project::where('status', 1)->get();
                $services = Service::where('status', 1)->get();
                $locations = Location::all();
                $casestudy = CaseStudy::find($casestudy_id);
                // dd($casestudy);
                return view('admin.casestudies.edit', compact('brands', 'services', 'locations', 'projects', 'casestudy'));
            } catch(\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function removeImage($casestudy_id, $image_id)
    {
        // dd($project_id);
        // dd($image_id);
        $image = CaseStudyImage::where('case_study_id', $casestudy_id)->where('id', $image_id)->first();
        $image_delete_path = public_path("uploads/case_study/images/".$image->image);
        if(File::exists($image_delete_path)) {
            File::delete($image_delete_path);
        }
         
        $image->delete();
        return redirect()->back()->with('success', 'Case study image deleted successfully');
    }

}
