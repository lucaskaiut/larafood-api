<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'description', 'url', 'price'];

    public function details(){
        return $this->hasMany(DetailPlan::class);
    }

    public function search($filter = null){
        $results = $this
            ->where('name', 'LIKE', "%{$filter}%")
            ->orWhere('description', 'LIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }

    public function profiles(){
        return $this->belongsToMany(Profile::class, 'profile_plan');
    }

    public function tenants(){
        return $this->hasMany(Tenant::class);
    }

    public function profilesAvailable($filter = null){
        $profiles = Profile::whereNotIn('id', function($query){
            $query->select('profile_plan.profile_id');
            $query->from('profile_plan');
            $query->whereRaw("plan_id = {$this->id}");
        })
            ->where(function($queryFilter) use ($filter){
                if($filter)
                    $queryFilter->where('profiles.name', 'LIKE', "%{$filter}%");
            })
            ->paginate();

        return $profiles;
    }

}
