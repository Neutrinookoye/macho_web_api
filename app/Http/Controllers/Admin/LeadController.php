<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use App\Exports\ExportLead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

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
    
    public function exportLead()
    {
        if(!checkPermission('export_leads'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try{
            return Excel::download(new ExportLead, 'leads.xlsx');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
    }
}
