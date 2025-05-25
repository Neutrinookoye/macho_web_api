<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsLetterExport;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    //
    public function index()
    {
        // if(!checkPermission('view_newsletters'))
        // {
            // return redirect()->back()->with('danger', 'Access Forbidden');
        // }
        $newsletters = Newsletter::orderBy('created_at', 'DESC')->get();
        // dd($brands);   
        return view('admin.newsletter.index', compact('newsletters'));
    }

    public function exportNewsletter(Request $request)
    {
        // if (!checkPermission('export_newsletters')) {
        //     return redirect()->back()->with('danger', 'Access Forbidden');
        // }
        try {
            $query = Newsletter::query();

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $request->validate([
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ]);

                // $startDate = $request->start_date;
                // $endDate = $request->end_date;

                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $newsletters = $query->orderByDesc('created_at', 'desc')->get();

            return Excel::download(new NewsLetterExport($newsletters), 'newsletters.xlsx');
        } catch (ValidationException $e) {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
