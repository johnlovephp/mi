<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    //指定关联数据库表名
    protected $table = 'adminMenu';
    //指定关联数据库表主键
    protected $primaryKey = 'id';
}