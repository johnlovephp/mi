<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'order';

    public $fillable = ['order_sn', 'member_id', 'buy_user', 'buy_phone', 'address', 'total', 'order_status'];
}