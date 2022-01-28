<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $params = [
            'permissions' => $permissions,
        ];
        return view('permissions.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach($request->status as $uuid => $value) {
            $permission = Permission::where('uuid', $uuid)->first();
            $permission->status = $value;
            $permission->save();
        }
        return redirect()->route('permissions')
            ->with('success', __('Permissions updated'));
    }
}
