<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MenuRepository
{
    public function index()
    {
        $menus = Menu::with('parent')->get();

        return DataTables::of($menus)

            ->addColumn('status', function($menu) {
                if($menu->status == 'active')
                    return '<span class="badge bg-success">Active</span>';
                else
                    return '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('icon', function($menu) {
                return '<i style="font-size: 18px" class="' . $menu->icon . '"></i>';
            })

            ->addColumn('parent', function ($menu) {
                if($menu->parent_id == null)
                    return 'N/A';
                else
                    return $menu->parent->name;
            })
            ->addColumn('updated_by', function ($menu) {
                return $menu->updatedBy->username . ' at ' . Carbon::parse($menu->updated_at)->format('d M Y ') ;
            })

            ->addColumn('action', function ($menu) {
                    $edit_button = '<div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="' . route('menus.edit', $menu->id) . '" class="dropdown-item"><i class="ri-pencil-fill edit-icon align-bottom me-2 text-warning"></i> Edit</a></li>
                        <li>
                            <a href="javascript:void(0)" class="dropdown-item" onclick="deleteMenu('.$menu->id.')">
                                <i class="ri-delete-bin-6-fill align-bottom me-2 text-danger"></i> Delete
                            </a>
                        </li>
                    </ul>
                </div>';
                return $edit_button;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'icon', 'status'])
            ->make(true);
    }

    public function show($menu_id)
    {
        return Menu::with('parent')->find($menu_id);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'status' => 'required',
            'parent_id' => 'nullable',
            'hierarchy' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if($request->url!='#' && !array_key_exists($request->url, app('router')->getRoutes()->getRoutesByName()))
            {
                return [
                    'status' => 'error',
                    'message' => 'Invalid URL'
                ];
            }

            $menu = new Menu();
            $menu->name = $request->name;
            $menu->url = $request->url;
            $menu->type = $request->type;
            $menu->status = $request->status;
            $menu->parent_id = $request->parent_id;
            $menu->icon = $request->icon;
            $menu->hierarchy = $request->hierarchy;     
            $menu->save();

            if($request->permissions){
                foreach ($request->permissions as $key=>$permission) {
                    if(array_key_exists('all', $permission))
                    {
                        $menu->roles()->attach($key, [
                            'menu_id' => $menu->id,
                            'acc_view' => 1,
                            'acc_create' => 1,
                            'acc_edit' => 1,
                            'acc_delete' => 1,
                            'acc_download' => 1,
                            'updated_by' => auth()->user()->id,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                        continue;
                    }

                    $menu->roles()->attach($key, [
                        'menu_id' => $menu->id,
                        'acc_view' => array_key_exists('view', $permission) ? 1 : 0,
                        'acc_create' =>  array_key_exists('create', $permission) ? 1 : 0,
                        'acc_edit' => array_key_exists('edit', $permission) ? 1 : 0,
                        'acc_delete' => array_key_exists('delete', $permission) ? 1 : 0,
                        'acc_download' => array_key_exists('download', $permission) ? 1 : 0,
                        'updated_by' => auth()->user()->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }    
            }    

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Menu Created Successfully'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }


    }

    public function update($request, $menu_id)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'status' => 'required',
            'parent_id' => 'nullable',
            'hierarchy' => 'required',
        ]);

        if($request->url!='#' && !array_key_exists($request->url, app('router')->getRoutes()->getRoutesByName()))
        {
            return [
                'status' => 'error',
                'message' => 'Invalid URL'
            ];
        }

        DB::beginTransaction();
        try {
            $menu = $this->show($menu_id);
            $menu->name = $request->name;
            $menu->url = $request->url;
            $menu->status = $request->status;
            $menu->parent_id = $request->parent_id;
            $menu->icon = $request->icon;
            $menu->hierarchy = $request->hierarchy; 
            $menu->save();

            $menu->roles()->sync([]);

            if($request->permissions){
                foreach ($request->permissions as $key=>$permission) {
                    if(array_key_exists('all', $permission))
                    {
                        $menu->roles()->attach($key, [
                            'menu_id' => $menu->id,
                            'acc_view' => 1,
                            'acc_create' => 1,
                            'acc_edit' => 1,
                            'acc_delete' => 1,
                            'acc_download' => 1,
                            'updated_by' => auth()->user()->id,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                        continue;
                    }

                    $menu->roles()->attach($key, [
                        'menu_id' => $menu->id,
                        'acc_view' => array_key_exists('view', $permission) ? 1 : 0,
                        'acc_create' =>  array_key_exists('create', $permission) ? 1 : 0,
                        'acc_edit' => array_key_exists('edit', $permission) ? 1 : 0,
                        'acc_delete' => array_key_exists('delete', $permission) ? 1 : 0,
                        'acc_download' => array_key_exists('download', $permission) ? 1 : 0,
                        'updated_by' => auth()->user()->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }


            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Menu Updated Successfully'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }
        

    public function destroy($request, $menu_id)
    {
        if($request->ajax())
        {
            try {
                $menu = $this->show($menu_id);
                $menu->roles()->sync([]);
                $menu->delete();

                return [
                    'status' => 'success',
                    'message' => 'Menu deleted successfully.'
                ];
            } catch (\Throwable $th) {
                return [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ];
            }
        }
    }

    public function getMenus()
    {
        return Menu::where('status', 'active')->get();
    }

    public function getRoles()
    {
        return Role::where('status', 'active')->where('name', '!=', 'Super Admin')->get();
    }

    public function getSelectedRoles($menu_id)
    {
        $roles_with_permissions_array = [];

        $roles = Menu::find($menu_id)->roles;

        foreach ($roles as $role) {
            $roles_with_permissions_array[$role->id] = [
                'acc_view' => $role->pivot->acc_view,
                'acc_create' => $role->pivot->acc_create,
                'acc_edit' => $role->pivot->acc_edit,
                'acc_delete' => $role->pivot->acc_delete,
                'acc_download' => $role->pivot->acc_download
            ];
        }

        // dd($roles_with_permissions_array);

        return $roles_with_permissions_array;
    }
}