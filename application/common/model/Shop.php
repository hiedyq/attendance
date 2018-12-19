<?php
namespace app\common\model;

class Shop extends BaseModel
{
  public function company() {
    return $this->belongsTo( 'Company', 'company_id', 'id' )
      ->bind( 'name' );
  }

  public function department() {
    return $this->hasMany( 'Department', 'shop_id', 'id' );
  }
}