<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RoleRepository;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        $request->session()->now('view_name', 'roles.index');
        try{
            if($request->ajax())
            {
                return $this->roleRepository->index();
            }

            return view('role.index');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function show(Request $request, $role_id)
    {
        $request->session()->now('view_name', 'roles.index');
        $role = $this->roleRepository->show($role_id);

        if($role != null){
            return view('role.show', compact('role'));
        }
        else{
            return redirect()->route('roles.index')->with('error', 'Role Not Found');
        }
    }

    public function create(Request $request)
    {
        $request->session()->now('view_name', 'roles.index');
        try{
            $roles = $this->roleRepository->getRoles();
            $menus = $this->roleRepository->getMenus();

            return view('role.create', compact('roles', 'menus'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit(Request $request, $role_id)
    {   
        $request->session()->now('view_name', 'roles.index');
        $role = $this->roleRepository->show($role_id);

        if($role != null){
            $roles = $this->roleRepository->getRoles();
            $menus = $this->roleRepository->getMenus();
            $selected_menus = $this->roleRepository->getSelectedMenus($role_id);

            return view('role.edit', compact('role', 'roles', 'menus', 'selected_menus'));
        }
        else{
            return redirect()->route('roles.index')->with('error', 'Role Not Found');
        }
    }

    public function store(Request $request)
    {
        $response = $this->roleRepository->store($request);

        if($response['status'] == 'success'){
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function update(Request $request, $role_id)
    {
        $response = $this->roleRepository->update($request, $role_id);

        if($response['status'] == 'success'){
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function destroy(Request $request)
    {
        $response = $this->roleRepository->destroy($request, $request->role_id);

        if($response['status'] == 'success'){
            return response()->json(['success' => $response['message']]);
        }
        else{
            return response()->json(['error' => $response['message']]);
        }
    }
}
