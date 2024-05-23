<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use App\Http\Traits\ModelBootTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory,SoftDeletes, ModelBootTrait;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_role')
                    ->withPivot('acc_view', 'acc_create', 'acc_edit', 'acc_delete', 'acc_download');
    }

}
