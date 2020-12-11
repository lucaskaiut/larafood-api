<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{

    use Notifiable, UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeTenantUser(Builder $query){
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function rolesAvailable($filter = null){
        $roles = Role::whereNotIn('id', function($query){
            $query->select('role_user.role_id');
            $query->from('role_user');
            $query->whereRaw("role_id = {$this->id}");
        })
            ->where(function($queryFilter) use ($filter){
                if($filter)
                    $queryFilter->where('roles.name', 'LIKE', "%{$filter}%");
            })
            ->paginate();

        return $roles;
    }

}
