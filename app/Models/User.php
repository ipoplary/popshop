<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
