<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends  Authenticatable implements JWTSubject
{
    protected $table = 'admin';
    protected $remeberTokenName = NULL;
    protected $guarded = [];
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }


    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }
    public static function creteAdmin($reques)
    {
        $re=self::create([
            'admin_id'=> $reques['admin_id'],
            'password'=>$reques['password']
        ]);
        return $re;
    }




}
