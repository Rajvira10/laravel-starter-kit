<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Http\Traits\ModelBootTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory,SoftDeletes, ModelBootTrait;

    public function roles()
    {
        return $this->belongsToMany(Role::class)
                    ->withPivot('acc_view', 'acc_create', 'acc_edit', 'acc_delete', 'acc_download');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function hasPermission()
    {
        return $this->roles()->where('role_id', auth()->user()->role_id)->exists() || auth()->user()->role->name == 'Super Admin';
    }
}
