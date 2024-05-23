<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Traits\ModelBootTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelBootTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function authorize($permission)
    {
        $permission = explode('.', $permission)[1];
        $permission = 'acc_' . $permission;
        
        $menu_url = explode('.', $permission)[0];
        $menu_url = $menu_url . '.index';

        return $this->role->menus()->where('url', $menu_url)->where($permission, 1)->exists() || $this->role->name == 'Super Admin';
    }

    public function hasPermission($route_name)
    {
        $role = $this->role;

        $route = explode('.', $route_name)[0];
        $permission = explode('.', $route_name)[1];

        if($permission == 'index')
        {
            $permission = 'acc_view';
        }
        elseif($permission == 'create')
        {
            $permission = 'acc_create';
        }
        elseif($permission == 'edit')
        {
            $permission = 'acc_edit';
        }
        elseif($permission == 'show')
        {
            $permission = 'acc_view';
        }
        elseif($permission == 'store')
        {
            $permission = 'acc_create';
        }
        elseif($permission == 'update')
        {
            $permission = 'acc_edit';
        }
        elseif($permission == 'destroy')
        {
            $permission = 'acc_delete';
        }

        $route = $route . '.index';

        return $role->menus()->where('url', $route)->where($permission, 1)->exists() || $role->name == 'Super Admin';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }
}
