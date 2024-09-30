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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
                    'short_description' => 'bail|required|string',
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
                    'threeD_icon' => 'bail|required',
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
                    if ($featuredCaseStudyCount >= 1) {
                        return redirect()->back()->with('danger', 'Sorry! Only 1 case study can be featured at a time.');
                    }
                }
                // dd($request);

                if($request->hasFile('first_background_image'))
                {
                    $firstBackgroundImageUrl = Cloudinary::upload($request->file('first_background_image')->getRealPath(),
                    [
                        'folder' => 'case_study/backgrounds',
                    ])->getSecurePath();
                    // $background_image_path = public_path("uploads/case_study/backgrounds");

                    // $first_background = $request->file("first_background_image");
                    // $first_background_name = Str::random(16).'.'.$first_background->extension();

                    // if($first_background->move($background_image_path, $first_background_name))
                    // {
                    //     $first_background = $first_background_name;
                    // }
                }else{
                    $firstBackgroundImageUrl = null;
                }   

                if($request->hasFile('second_background_image'))
                {
                    $secondBackgroundImageUrl = Cloudinary::upload($request->file('second_background_image')->getRealPath(),
                    [
                        'folder' => 'case_study/backgrounds',
                    ])->getSecurePath();
                    // $background_image_path = public_path("uploads/case_study/backgrounds");

                    // $second_background = $request->file("second_background_image");
                    // $second_background_name = Str::random(16).'.'.$second_background->extension();

                    // if($second_background->move($background_image_path, $second_background_name))
                    // {
                    //     $second_background = $second_background_name;
                    // }
                }else{
                    $secondBackgroundImageUrl = null;
                }

                if($request->hasFile('logo'))
                {
                    $logoUrl = Cloudinary::upload($request->file('logo')->getRealPath(),
                    [
                        'folder' => 'case_study/logos',
                    ])->getSecurePath();
                    // $logo_path = public_path("uploads/case_study/logos");

                    // $logo = $request->file("logo");
                    // $logo_name = Str::random(16).'.'.$logo->extension();

                    // if($logo->move($logo_path, $logo_name))
                    // {
                    //     $logo = $logo_name;
                    // }
                }else{
                    $logoUrl = null;
                }
                if($request->hasFile('threeD_icon'))
                {
                    $iconurl = Cloudinary::upload($request->file('threeD_icon')->getRealPath(),
                    [
                        'folder' => 'case_study/3D_icon',
                    ])->getSecurePath();
                    // $logo_path = public_path("uploads/case_study/logos");

                    // $logo = $request->file("logo");
                    // $logo_name = Str::random(16).'.'.$logo->extension();

                    // if($logo->move($logo_path, $logo_name))
                    // {
                    //     $logo = $logo_name;
                    // }
                }else{
                    $iconurl = null;
                }

                if($request->hasFile('document'))
                {
                    // $documentUrl = Cloudinary::uploadFile($request->file('document')->getRealPath(), 
                    // [
                    //     'folder' => 'case_study/document',
                    // ])->getSecurePath();
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
                
                // if($request->hasFile('threeD_icon'))
                // {
                //     // $documentUrl = Cloudinary::uploadFile($request->file('document')->getRealPath(), 
                //     // [
                //     //     'folder' => 'case_study/document',
                //     // ])->getSecurePath();
                //     $icon_path = public_path("uploads/case_study/3D_icon");

                //     $icon = $request->file("threeD_icon");
                //     $icon_name = Str::random(16).'.'.$icon->extension();

                //     if($document->move($icon_path, $icon_name))
                //     {
                //         $threeD_icon = $icon_name;
                //     }
                // }else{
                //     $threeD_icon = null;
                // }
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
                    'short_description' => $request->short_description,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'video_url' => $request->video_url,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $firstBackgroundImageUrl,
                    'page_bg2' => $secondBackgroundImageUrl,
                    'logo' => $logoUrl,
                    'document' => $document,
                    'threeD_icon' => $iconurl,
                    'created_by' => auth()->user()->id,
                ]);

                if (is_array($request->images)) {
                    // $image_path = public_path("uploads/case_study/images");
                    // foreach ($request->file('images') as $image) {
                    //     $uploadedImageUrl = Cloudinary::upload($request->file($image)->getRealPath(),
                    //     [
                    //         'folder' => 'case_study/images',
                    //     ])->getSecurePath();
                    //     // $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                    //     // if ($image->move($image_path, $image_name)) {
                    //         CaseStudyImage::create([
                    //             'case_study_id' => $casestudy->id,
                    //             'image' => $uploadedImageUrl,
                    //         ]);
                    //     // }
                    // }
                    foreach ($request->file('images') as $image) {
                        if ($image->isValid()) {
                            $uploadedImageUrl = Cloudinary::upload($image->getRealPath(), [
                                'folder' => 'case_study/images',
                            ])->getSecurePath();
                            CaseStudyImage::create([
                                'project_id' => $casestudy->id,
                                'image' => $uploadedImageUrl,
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
                    'short_description' => 'bail|required|string',
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
                    'threeD_icon' => 'bail|nullable',
                    'document' => 'bail|nullable',
                    'edited_by' => 'bail|integer',
                ]);
                // dd($request);

                $slug = Str::slug($request->name);

                $checkcasestudy = CaseStudy::where('slug', $slug)->where('id', '!=', $casestudy_id)->first();
                if($checkcasestudy)
                {
                    return redirect()->back()->with('danger', 'Sorry! A case study already exists with this name.')->withInput();
                }

                if ($request->is_featured) {
                    $featuredCaseStudyCount = CaseStudy::where('is_featured', 1)->count();
                    if ($featuredCaseStudyCount >= 1) {
                        return redirect()->back()->with('danger', 'Sorry! Only 1 case study can be featured at a time.');
                    }
                }

                // dd($request);

                $casestudy = CaseStudy::find($casestudy_id);
                // dd($casestudy);

                if($request->hasFile('first_background_image'))
                {
                    $firstBackgroundImageUrl = Cloudinary::upload($request->file('first_background_image')->getRealPath(),
                    [
                        'folder' => 'case_study/backgrounds',
                    ])->getSecurePath();
                    // $background_image_path = public_path("uploads/case_study/backgrounds");

                    // $first_background = $request->file("first_background_image");
                    // $first_background_name = Str::random(16).'.'.$first_background->extension();

                    // if($first_background->move($background_image_path, $first_background_name))
                    // {
                    //     $first_background = $first_background_name;
                    // }
                }else{
                    $firstBackgroundImageUrl = $casestudy->page_bg;
                }

                if($request->hasFile('second_background_image'))
                {
                    $secondBackgroundImageUrl = Cloudinary::upload($request->file('second_background_image')->getRealPath(),
                    [
                        'folder' => 'case_study/backgrounds',
                    ])->getSecurePath();
                    // $background_image_path = public_path("uploads/case_study/backgrounds");

                    // $second_background = $request->file("second_background_image");
                    // $second_background_name = Str::random(16).'.'.$second_background->extension();

                    // if($second_background->move($background_image_path, $second_background_name))
                    // {
                    //     $second_background = $second_background_name;
                    // }
                }else{
                    $secondBackgroundImageUrl = $casestudy->page_bg2;
                }

                if($request->hasFile('logo'))
                {
                    $logoUrl = Cloudinary::upload($request->file('logo')->getRealPath(),
                    [
                        'folder' => 'case_study/logos',
                    ])->getSecurePath();
                    // $logo_path = public_path("uploads/case_study/logos");

                    // $logo = $request->file("logo");
                    // $logo_name = Str::random(16).'.'.$logo->extension();

                    // if($logo->move($logo_path, $logo_name))
                    // {
                    //     $logo = $logo_name;
                    // }
                }else{
                    $logoUrl = $casestudy->logo;
                }
                if($request->hasFile('threeD_icon'))
                {
                    $iconurl = Cloudinary::upload($request->file('threeD_icon')->getRealPath(),
                    [
                        'folder' => 'case_study/3D_icon',
                    ])->getSecurePath();
                    // $logo_path = public_path("uploads/case_study/logos");

                    // $logo = $request->file("logo");
                    // $logo_name = Str::random(16).'.'.$logo->extension();

                    // if($logo->move($logo_path, $logo_name))
                    // {
                    //     $logo = $logo_name;
                    // }
                }else{
                    $iconurl = $casestudy->threeD_icon;
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
                    'short_description' => $request->short_description,
                    'about' => $request->about,
                    'brief' => $request->brief,
                    'challenge' => $request->challenge,
                    'approach' => $request->approach,
                    'outcome' => $request->outcome,
                    'video_url' => $request->video_url,
                    'status' => $request->status ?? 0,
                    'is_featured' => $request->is_featured ?? 0,
                    'page_bg' => $firstBackgroundImageUrl,
                    'page_bg2' => $secondBackgroundImageUrl,
                    'logo' => $logoUrl,
                    'threeD_icon' => $iconurl,
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
    
                    // $image_path = public_path("uploads/case_study/images");
                    // foreach ($newImages as $image) {
                    //     $image_name = Str::random(16) . '_' . time() . '.' . $image->extension();
                    //     if ($image->move($image_path, $image_name)) {
                    //         CaseStudyImage::create([
                    //             'case_study_id' => $casestudy->id,
                    //             'image' => $uploadedImageUrl,
                    //         ]);
                    //     }
                    // }

                    foreach ($newImages as $image) {
                        if ($image->isValid()) {
                            $uploadedImageUrl = Cloudinary::upload($image->getRealPath(), [
                                'folder' => 'projects/images',
                            ])->getSecurePath();
                            CaseStudyImage::create([
                                'case_study_id' => $casestudy->id,
                                'image' => $uploadedImageUrl,
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
