<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{
    public function index()
    {
        if(auth()->user()->role->name == 'Super Admin')
        {
            $users = User::with('role')->get();
        }
        else
        {
            $users = User::find(auth()->user()->id)->with('role')->get();
        }

        return DataTables::of($users)
            ->addColumn('updated_by', function ($user) {
                return $user->updatedBy->username . ' at ' . Carbon::parse($user->updated_at)->format('d M Y ') ;
            })

            ->addColumn('status', function($user){
                return $user->status == 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            })
           
            ->addColumn('role', function ($user) {
                if(!$user->role){
                    return 'N/A';
                }
                return $user->role->name;
            })
            ->addColumn('action', function ($user) {
                    $edit_button = '<div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">';
                    if(auth()->user()->authorize('users.view')){
                        $edit_button .= '<li><a href="' . route('users.show', $user->id) . '" class="dropdown-item"><i class="ri-eye-fill eye-icon align-bottom me-2 text-primary"></i> View</a></li>';
                    }
                    if(auth()->user()->authorize('users.edit')){
                        $edit_button .= '<li><a href="' . route('users.edit', $user->id) . '" class="dropdown-item"><i class="ri-pencil-fill edit-icon align-bottom me-2 text-warning"></i> Edit</a></li>';
                    }
                    if(auth()->user()->authorize('users.delete')){
                        $edit_button .= '<li>
                            <a href="javascript:void(0)" class="dropdown-item" onclick="deleteUser('.$user->id.')">
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

    public function show($user_id)
    {
        if(!auth()->user()->role->name == 'Super Admin')
        {
            if(auth()->user()->id != $user_id)
            {
                return null;
            }
        }

        return User::with('role')->find($user_id);
    }

    public function store($request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:100'
        ]);

        try {
            $user = new User();
            $user->role_id = $request->role_id;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);

            if ($request->file('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image_path = 'images/users/' . $image_name;
                Storage::disk('public')->put($image_path, file_get_contents($image));
                $absolute_path = asset('storage/' . $image_path);
                $user->image = $absolute_path;
            }

            $user->save();

            return [
                'status' => 'success',
                'message' => 'User created successfully.'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

    public function update($request, $user_id)
    {
        if(!auth()->user()->role->name == 'Super Admin')
        {
            if(auth()->user()->id != $user_id)
            {
                return null;
            }
        }

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id,
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:100',
            'password' => 'nullable|min:6|confirmed'
        ]);

        try {
            $user = User::find($user_id);
            $user->role_id = $request->role_id;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->status = $request->status;
            
            if($request->password)
            {
                $user->password = Hash::make($request->password);
            }

            if ($request->file('image')) {
                $old_image = $user->image;
                if($old_image != null)
                {
                    $old_image_path = str_replace(asset('storage/'), '', $old_image);
                    Storage::disk('public')->delete($old_image_path);
                }

                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image_path = 'images/users/' . $image_name;
                Storage::disk('public')->put($image_path, file_get_contents($image));
                $absolute_path = asset('storage/' . $image_path);
                $user->image = $absolute_path;
            }

            $user->save();

            return [
                'status' => 'success',
                'message' => 'User updated successfully.'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

    public function destroy($request, $user_id)
    {
        if($request->ajax())
        {
            if(!auth()->user()->role->name == 'Super Admin')
            {
                if(auth()->user()->id != $user_id)
                {
                    return null;
                }
            }
            
            try {
                $user = User::find($user_id);
                $user->delete();

                return [
                    'status' => 'success',
                    'message' => 'User deleted successfully.'
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
        return Role::where('status', 'active')->get();
    }
    
}