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
    
    // public function exportLead(Request $request)
    // {
    //     if(!checkPermission('export_leads'))
    //     {
    //         return redirect()->back()->with('danger', 'Access Forbidden');
    //     }
    //     try{
    //         // dd($request);
    //         $request->validate([
    //             'start_date' => 'required|date',
    //             'end_date' => 'required|date|after_or_equal:start_date',
    //         ]);

    //         $startDate = $request->start_date;
    //         $endDate = $request->end_date;

    //         $leads = Lead::whereBetween('created_at', [$startDate, $endDate])
    //                     ->orderByDesc('created_at')
    //                     ->get();            
    //         // dd($leads);

    //         return Excel::download(new ExportLead($leads), 'leads.xlsx');

    //     } catch (ValidationException $e)
    //     {
    //         return redirect()->back()->with('danger', $e->validator->errors()->first());
    //     } catch (\Exception $e)
    //     {
    //         return redirect()->back()->with('danger', $e->getMessage());

    //     }
    // }
    public function exportLead(Request $request)
    {
        if (!checkPermission('export_leads')) {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $query = Lead::query();

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $request->validate([
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ]);

                $startDate = $request->start_date;
                $endDate = $request->end_date;

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $leads = $query->orderByDesc('created_at')->get();

            return Excel::download(new ExportLead($leads), 'leads.xlsx');
        } catch (ValidationException $e) {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

}
