<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_leads'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $leads = Lead::orderBy('created_at', 'DESC')->get();
        // dd($brands);   
        return view('admin.leads.index', compact('leads'));
    }
}
