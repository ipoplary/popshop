<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
