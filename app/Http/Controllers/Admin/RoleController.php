<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_roles'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        return view('admin.system.roles');
    }

    public function createRole(Request $request)
    {
        if(!checkPermission('create_role'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $request->validate([
                'name' => 'bail|string|required',
                'status' => 'nullable|integer',
                'permissions' => 'required|array',
            ]);

            $data = [
                'name' => $request->name, 
                'status' => $request->status ?? 0
            ];
            createAccess($data, 'role', $request->permissions);

            return redirect()->route('admin.roles.index')->with('success', "{$request->name} has been created successfully.");

        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }


    public function updateRole(Request $request, $role_id)
    {
        if(!checkPermission('edit_role'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $request->validate([
                'name' => 'bail|string|required',
                'status' => 'nullable|integer',
                'permissions' => 'required|array'
            ]);

            $data = [
                'data_id' => $role_id,
                'name' => $request->name,
                'status' => $request->status ?? 0,
            ];
            updateAccess($data, 'role', $request->permissions);

            return redirect()->route('admin.roles.index')->with('success', "{$request->name} has been updated successfully.");

        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first());
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
}
