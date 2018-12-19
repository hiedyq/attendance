<?php
namespace app\common\model;

class User extends BaseModel
{
    public function token() {
        return $this->hasMany( 'Token', 'user_id', 'id' );
    }
}