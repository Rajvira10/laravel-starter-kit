<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MenuRoleRepository
{
    public function index()
    {
        $menu_roles = Menu::leftJoin('menu_role', 'menus.id', '=', 'menu_role.menu_id')
            ->leftJoin('roles', 'roles.id', '=', 'menu_role.role_id')
            ->leftJoin('users', 'users.id', '=', 'menu_role.updated_by')
            ->select('menus.id as menu_id', 'menus.name as menu_name', 'roles.id as role_id', 'roles.name as role_name', 'menu_role.acc_view', 'menu_role.acc_create', 'menu_role.acc_edit', 'menu_role.acc_delete', 'menu_role.acc_download', 'users.username as menu_role_updated_by', 'menu_role.updated_at')
            ->get();


        return DataTables::of($menu_roles)
            ->addColumn('role_name', function($menu_role) {
                if($menu_role->role_name == null)
                    return 'N/A';
                
                return $menu_role->role_name;
            })
            ->addColumn('menu_name', function($menu_role) {
                return $menu_role->menu_name;
            })

            ->addColumn('acc_view', function($menu_role) {
                if($menu_role->acc_view == 1)
                    return '<span class="badge bg-success">Yes</span>';
                else
                    return '<span class="badge bg-danger">No</span>';
            })            
            ->addColumn('acc_create', function($menu_role) {
                if($menu_role->acc_create == 1)
                    return '<span class="badge bg-success">Yes</span>';
                else
                    return '<span class="badge bg-danger">No</span>';
            })            
            ->addColumn('acc_edit', function($menu_role) {
                if($menu_role->acc_edit == 1)
                    return '<span class="badge bg-success">Yes</span>';
                else
                    return '<span class="badge bg-danger">No</span>';
            })            
            ->addColumn('acc_delete', function($menu_role) {
                if($menu_role->acc_delete == 1)
                    return '<span class="badge bg-success">Yes</span>';
                else
                    return '<span class="badge bg-danger">No</span>';
            })            
            ->addColumn('acc_download', function($menu_role) {
                if($menu_role->acc_download == 1)
                    return '<span class="badge bg-success">Yes</span>';
                else
                    return '<span class="badge bg-danger">No</span>';
            })
            ->addColumn('updated_by', function ($menu_role) {
                if($menu_role->menu_role_updated_by == null)
                    return 'N/A';
                return $menu_role->menu_role_updated_by . ' at ' . Carbon::parse($menu_role->updated_at)->format('d M Y ') ;
            })
            ->addColumn('action', function($menu_role) {
                if($menu_role->menu_id == null){
                    return '';
                }
                $edit_button = '<a href='.route('menus.edit', $menu_role->menu_id).'>
                <button class="btn btn-warning btn-sm dropdown">
                    <i class="ri-edit-fill align-middle"></i> Edit
                </button>
                </a>';
                return $edit_button;
            })
            ->rawColumns(['acc_view', 'acc_create', 'acc_edit', 'acc_delete', 'acc_download','action'])
            ->make(true);
    }
}
