<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RoleRepository
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return DataTables::of($roles)
            ->addColumn('updated_by', function ($role) {
                return $role->updatedBy->username . ' at ' . Carbon::parse($role->updated_at)->format('d M Y ') ;
            })
            
            ->addColumn('status', function($role){
                return $role->status == 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($role) {
                    $edit_button = '<div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">';

                    if(auth()->user()->authorize('roles.edit')){
                        $edit_button .= '<li><a href="' . route('roles.edit', $role->id) . '" class="dropdown-item"><i class="ri-pencil-fill edit-icon align-bottom me-2 text-warning"></i> Edit</a></li>';
                    }
                    if(auth()->user()->authorize('roles.delete')){
                        $edit_button .= '<li>
                            <a href="javascript:void(0)" class="dropdown-item" onclick="deleteRole('.$role->id.')">
                                <i class="ri-delete-bin-6-fill align-bottom me-2 text-danger"></i> Delete
                            </a>
                        </li>';
                    }
                    $edit_button .= '
                                </ul>
                            </div>';

                return $edit_button;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function show($role_id)
    {
        return Role::find($role_id);
    }

    public function store($request)
    {
        
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
            'status' => 'required',
            // 'permissions' => "required"
        ]);
        DB::beginTransaction();
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->status = $request->status;
            $role->save();         

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Role Created Successfully'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }


    }

    public function update($request, $role_id)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        try {
            $role = $this->show($role_id);
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->status = $request->status;
            $role->save();

            return [
                'status' => 'success',
                'message' => 'Role Updated Successfully'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }
        

    public function destroy($request, $role_id)
    {
        if($request->ajax())
        {
            try {
                $role = $this->show($role_id);
                $users = $role->users;
                if(count($users) > 0){
                    return [
                        'status' => 'error',
                        'message' => 'Role cannot be deleted because it has users.'
                    ];
                }
                $role->delete();

                return [
                    'status' => 'success',
                    'message' => 'Role deleted successfully.'
                ];
            } catch (\Throwable $th) {
                return [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ];
            }
        }
    }

    public function getRoles()
    {
        return Role::where('status', 'active')->where('name', '!=', 'Super Admin')->get();
    }

    public function getMenus()
    {
        return Menu::where('status', 'active')->get();
    }

    public function getSelectedMenus($role_id)
    {
       $selected_menus = Role::find($role_id)->menus()->pluck('menu_id','acc_view','acc_create','acc_edit','acc_delete','acc_download')->toArray();
    }
}