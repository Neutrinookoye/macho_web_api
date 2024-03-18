<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // if($request->isMethod('post'))
        // {
            try{
                $this->validate($request, [
                    'email' => 'bail|required|email',
                    'password' => 'bail|required'
                ]);

                if ($user = Auth::attempt([
                        'email' => $request->email,
                        'password' => $request->password
                    ]))
                {
                    $user = User::where('id', Auth::user()->id)->first();

                    if(!$user->admin())
                    {
                        return redirect()->back()->with('danger', 'Invalid Login Details');
                    }

                    $user->update([
                        'last_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => \Request::getClientIp(true)
                    ]);

                    return redirect()->route('admin.dashboard')->with('success', 'You have successfully logged in');
                }

                // dd('Invalid login details');

                return redirect()->back()->with('danger', 'Invalid Login Details');
            } catch (ValidationException $e)
            {
                // dd($e->validator->errors()->first());
                return redirect()->back()->with('danger', $e->validator->errors()->first());
            } catch (\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        // }else{
        //     try
        //     {
        //         return view('admin.auth.login');
        //     } catch(\Exception $e)
        //     {
        //         return redirect()->back()->with('danger', $e->getMessage());
        //     }
        // }

    }

    public function logout(Request $request)
    {
        try{
            $request->session()->flush();
            Auth::logout();
            return redirect()->route('home')->with('danger', 'You have been logged out');
        } catch(\Exception $e)
        {
            // dd($e->getMessage());
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
