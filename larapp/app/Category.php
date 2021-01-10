<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'image',
        'description'        
    ];

    public function categories() {
        return $this->hasMany('App\Game');
    }

    public function scopeNames($categories, $q) {
        if (trim($q)) {
            $categories->where('name','LIKE',"%$q%")
                  ->orWhere('description','LIKE',"%$q%");
        }
    }
}
