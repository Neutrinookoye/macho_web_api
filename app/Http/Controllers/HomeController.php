<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home()
    {
        try
        {
            return view('welcome');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
