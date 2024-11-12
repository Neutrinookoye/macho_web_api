<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\UserRoleHelper;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_admins'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $admins = User::where('admin', true)->orderBy('created_at', 'DESC')->get();
        // dd($admins);
        return view('admin.users.admins', compact('admins'));
    }

    public function createAdmin(Request $request)
    {
        if(!checkPermission('create_admin'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            // dd($request);
            $request->validate([
                'name' => 'bail|required|string',
                'email' => 'bail|required|email|unique:users,email',
                'password' => 'bail|required|min:6',
                'active' => 'nullable|integer',
                'role' => 'bail|required',
            ]);
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->active = $request->active ?? 0;
            $user->account = 9;
            $user->admin = 1;
            $user->save();

            UserRoleHelper::createUserRole($request->role, $user->id);
            // createUserRole($request->roles, $user->id);

            return redirect()->back()->with('success', "Admin has been created successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
            
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }

    public function updateAdmin(Request $request, $user_id)
    {
        if(!checkPermission('edit_admin'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            // dd($request);
            $request->validate([
                'name' => 'bail|required|string',
                'password' => 'bail|nullable ||min:6',
                'active' => 'nullable|integer',
                'role' => 'bail|required',
            ]);

            $user = User::find($user_id);
            $user->name = $request->name;
            $user->password = $request->password ? bcrypt($request->password) : $user->password;
            $user->active = $request->active ?? 0;
            $user->save();

            UserRoleHelper::updateUserRole($request->role, $user->id);
            // updateUserRole($request->roles, $user->id);

            return redirect()->back()->with('success', "Admin has been edited successfully.");
        } catch (ValidationException $th) 
        {
            return back()->with('danger', $th->validator->errors()->first());
        } catch (\Throwable $th) 
        {
            return back()->with('danger', $th->getMessage());
        }
    }
}
