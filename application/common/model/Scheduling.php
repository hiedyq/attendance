<?php
namespace app\common\model;

class Scheduling extends BaseModel
{
  public function department() {
    return $this->hasMany( 'DepartmentScheduling', 'scheduling_id', 'id' );
  }

  public function member() {
    return $this->hasMany( 'MemberScheduling', 'scheduling_id', 'id' );
  }

  public function clock() {
    return $this->hasMany( 'Clock', 'scheduling_id', 'id' );
  }

  public function ruler() {
    return $this->hasMany( 'Ruler', 'scheduling_id', 'id' );
  }
}