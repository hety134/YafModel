<?php

use Illuminate\Database\Eloquent\Model;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/18
 * Time: 16:24
 */
class UsersModel extends Model
{
    protected $table = "users";

    public function selectUser(){
        return "sky";
    }
}