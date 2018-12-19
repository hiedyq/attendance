<?php
namespace app\common\model;

class Token extends BaseModel
{
  public function User() {
    return $this->belongsTo( 'User', 'user_id', 'id' )
      ->bind( 'loginName' );
  }
}