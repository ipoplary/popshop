<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
