<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = new Menu();
        $menu->name = 'Permissions';
        $menu->icon = 'ri-shield-user-line';
        $menu->url = '#';
        $menu->parent_id = null;
        $menu->status = 'active';
        $menu->hierarchy = 1;
        $menu->save();

        $menu = new Menu();
        $menu->name = 'Users';
        $menu->icon = 'ri-user-3-line';
        $menu->url = 'users.index';
        $menu->parent_id = 1;
        $menu->status = 'active';
        $menu->hierarchy = 1;
        $menu->save();

        $menu = new Menu();
        $menu->name = 'Roles';
        $menu->icon = 'ri-user-3-line';
        $menu->url = 'roles.index';
        $menu->parent_id = 1;
        $menu->status = 'active';
        $menu->hierarchy = 2;
        $menu->save();

        $menu = new Menu();
        $menu->name = 'Menus';
        $menu->icon = 'ri-menu-line';
        $menu->url = 'menus.index';
        $menu->parent_id = 1;
        $menu->status = 'active';
        $menu->hierarchy = 3;
        $menu->save();

        $menu = new Menu();
        $menu->name = 'Menu Roles';
        $menu->icon = 'ri-folder-shield-fill';
        $menu->url = 'menu_roles.index';
        $menu->parent_id = 1;
        $menu->status = 'active';
        $menu->hierarchy = 4;
        $menu->save();
    }
}
