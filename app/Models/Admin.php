<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model implements AuthenticatableContract
{
    use SoftDeletes;

    use Authenticatable;

    protected $dates = ['deleted_at'];
}
