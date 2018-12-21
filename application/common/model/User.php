<?php
namespace app\common\model;

class User extends BaseModel
{
    public function shop() {
        return $this->belongsTo( 'Shop', 'shop_id', 'id' )
            ->bind( [ 'shop_name' => 'name' ] );
    }
    
    public function token() {
        return $this->hasMany( 'Token', 'user_id', 'id' );
    }
}