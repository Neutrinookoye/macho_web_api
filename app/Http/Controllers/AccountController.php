<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //
    public function dashboard()
    {
        // if(!checkPermission('view_dashboard'))
        // {
        //     return redirect()->back()->with('danger', 'Access Forbidden');
        // }
        try
        {

            return view('admin.dashboard');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
