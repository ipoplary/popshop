<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getParent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function getChildren()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }
}
