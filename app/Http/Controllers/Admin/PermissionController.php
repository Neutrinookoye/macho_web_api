<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_permission'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        return view('admin.system.permissions');
    }


    public function createPermission(Request $request)
    {
        if(!checkPermission('create_permission'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $request->validate([
                'name' => 'bail|string|required',
                'status' => 'nullable|integer',
            ]);

            createAccess(['name' => $request->name, 'status' => $request->status ?? 0], 'permission');

            return redirect()->route('admin.permissions.index')->with('success', "{$request->name} has been created successfully.");

        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }


    public function updatePermission(Request $request, $permission_id)
    {
        if(!checkPermission('edit_permission'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $request->validate([
                'name' => 'bail|string|required',
                'status' => 'nullable|integer',
            ]);

            $data = [
                'data_id' => $permission_id,
                'name' => $request->name,
                'status' => $request->status ?? 0,
            ];
            updateAccess($data, 'permission');

            return redirect()->route('admin.permissions.index')->with('success', "{$request->name} has been updated successfully.");

        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }
}
