<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Blog;
use App\Models\CaseStudy;
use App\Models\Lead;
use App\Models\Newsletter;
use App\Models\Opening;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //
    public function dashboard()
    {
        if(!checkPermission('view_dashboard'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            $no_of_leads = Lead::get()->count();
            $no_of_emails = Newsletter::get()->count();
            $no_of_openings = Opening::get()->count();
            $no_of_applications = Application::get()->count();
            $no_of_blogs = Blog::get()->count();
            $no_of_services = Service::get()->count();
            $no_of_projects = Project::get()->count();
            $no_of_case_studies = CaseStudy::get()->count();
            return view('admin.dashboard', compact('no_of_leads', 'no_of_emails', 'no_of_openings', 'no_of_applications', 'no_of_blogs', 'no_of_services', 'no_of_projects', 'no_of_case_studies'));
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
