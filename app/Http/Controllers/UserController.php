<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;


class UserController extends Controller
{
    
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }
    
    public function index(Request $request)
    {
        $request->session()->now('view_name', 'users.index');
        try{
            if($request->ajax())
            {
                return $this->userRepository->index();
            }

            return view('user.index');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function show(Request $request, $user_id)
    {
        $request->session()->now('view_name', 'users.index');
        $user = $this->userRepository->show($user_id);

        if($user != null){
            return view('user.show', compact('user'));
        }
        else{
            return redirect()->route('users.index')->with('error', 'User Not Found');
        }

    }

    public function create(Request $request)
    {
        $request->session()->now('view_name', 'users.index');
        try{
            $roles = $this->userRepository->getRoles();
            return view('user.create', compact('roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit(Request $request, $user_id)
    {   
        $request->session()->now('view_name', 'users.index');
        $user = $this->userRepository->show($user_id);

        if($user != null){
            $roles = $this->userRepository->getRoles();
            return view('user.edit', compact('user', 'roles'));
        }
        else{
            return redirect()->route('users.index')->with('error', 'User Not Found');
        }
    }

    public function store(Request $request)
    {   
        $response = $this->userRepository->store($request);

        if($response['status'] == 'success'){
            return redirect()->route('users.index')->with('success', $response['message']);
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function update(Request $request, $user_id)
    {
        $response = $this->userRepository->update($request, $user_id);

        if($response['status'] == 'success'){
            return redirect()->route('users.index')->with('success', $response['message']);
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function destroy(Request $request)
    {   
        $response = $this->userRepository->destroy($request, $request->user_id);

        if($response['status'] == 'success'){
            return response()->json(['success' => $response['message']]);
        }
        else{
            return response()->json(['error' => $response['message']]);
        }
    }

    public function userRoles(Request $request, $user_id)
    {
        try{
            $user = $this->userRepository->show($user_id);

            $roles = $this->userRepository->getRoles();
            
            $user_roles_array = $user->roles->pluck('id')->toArray();

            return view('user.user_roles', compact('roles', 'user_roles_array', 'user'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function assignRoles(Request $request, $user_id)
    {
        try{
            $user = $this->userRepository->show($user_id);

            if($user != null){

                $user->roles()->sync($request->roles);
    
                return redirect()->route('users.index')->with('success', 'User roles assigned successfully.');
            }
            else{
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
