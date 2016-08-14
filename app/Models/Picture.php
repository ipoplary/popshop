<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getPictureType()
    {
        return $this->belongsTo('App\Models\PictureType', 'type_id', 'id');
    }
}
