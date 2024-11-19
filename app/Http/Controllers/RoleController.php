<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function role(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.role', [
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }

    function permission_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);
        return back();
    }

    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->syncPermissions($request->permission);
        return back();
    }

    function role_assign(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return back();
    }

    function role_delete($role_id){
        DB::table('role_has_permissions')->where('role_id', $role_id)->delete();
        Role::find($role_id)->delete();
        return back();
    }

    function role_remove($user_id){
        $user = User::find($user_id);
        $user->syncRoles([]);
        return back();
    }
}
