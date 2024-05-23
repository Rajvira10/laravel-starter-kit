<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\MenuRepository;

class MenuController extends Controller
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        parent::__construct();
        $this->menuRepository = $menuRepository;
    }

    public function index(Request $request)
    {
        $request->session()->now('view_name', 'menus.index');
        try{
            if($request->ajax())
            {
                return $this->menuRepository->index();
            }

            return view('menu.index');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function create(Request $request)
    {
        $request->session()->now('view_name', 'menus.index');
        try{
            $menus = $this->menuRepository->getMenus();
            $roles = $this->menuRepository->getRoles();

            return view('menu.create', compact('menus', 'roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit(Request $request, $menu_id)
    {    
        $request->session()->now('view_name', 'menus.index');
        $menu = $this->menuRepository->show($menu_id);

        if($menu != null){
            $menus = $this->menuRepository->getMenus();
            $roles = $this->menuRepository->getRoles();
            $permissions = $this->menuRepository->getSelectedRoles($menu_id);

            return view('menu.edit', compact('menu', 'menus', 'permissions', 'roles'));
        }
        else{
            return redirect()->route('menus.index')->with('error', 'Menu Not Found');
        }
    }

    public function store(Request $request)
    {
        $response = $this->menuRepository->store($request);

        if($response['status'] == 'success'){
            return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function update(Request $request, $menu_id)
    {
        $response = $this->menuRepository->update($request, $menu_id);

        if($response['status'] == 'success'){

            return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
        }
        else{
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function destroy(Request $request)
    {
        $response = $this->menuRepository->destroy($request, $request->menu_id);

        if($response['status'] == 'success'){
            return response()->json(['success' => $response['message']]);
        }
        else{
            return response()->json(['error' => $response['message']]);
        }
    }
}
