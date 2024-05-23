<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\MenuRoleRepository;

class MenuRoleController extends Controller
{
    private $menuRoleRepository;

    public function __construct(MenuRoleRepository $menuRoleRepository)
    {
        parent::__construct();
        $this->menuRoleRepository = $menuRoleRepository;
    }
    
    public function index(Request $request)
    {
        $request->session()->now('view_name', 'menu_roles.index');

        try{
            if($request->ajax())
            {
                return $this->menuRoleRepository->index();
            }

            return view('menu_role.index');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
