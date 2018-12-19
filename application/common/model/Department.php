<?php
namespace app\common\model;

class Department extends BaseModel
{
  public function shop() {
    return $this->belongsTo( 'Shop', 'shop_id', 'id' )
      ->bind( 'name' );
  }

  public function sub() {
    return $this->hasMany( 'Department', 'pid', 'id' );
  }

  public function higher() {
    return $this->belongsTo( 'Department', 'pid', 'id' )
      ->bind( 'name' );
  }

  public function scheduling() {
    return $this->hasMany( 'DepartmentScheduling', 'department_id', 'id' );
  }

  public function member() {
    return $this->hasMany( 'Member', 'department_id', 'id' );
  }

  public function device() {
    return $this->hasMany( 'Device', 'scheduling_id', 'id' );
  }
}