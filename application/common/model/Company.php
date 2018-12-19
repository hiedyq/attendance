<?php
namespace app\common\model;

class Company extends BaseModel
{
  public function shop() {
    return $this->hasMany( 'Shop', 'company_id', 'id' );
  }
}