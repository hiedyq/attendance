<?php
namespace app\common\model;

class Member extends BaseModel
{
  public function department() {
    return $this->belongsTo( 'Department', 'department_id', 'id' )
      ->bind( 'name' );
  }

  public function visit() {
    return $this->hasMany( 'Visit', 'member_id', 'id' );
  }

  public function scheduling() {
    return $this->hasMany( 'MemberScheduling', 'member_id', 'id' );
  }

  public function leave() {
    return $this->hasMany( 'Leave', 'memver_id', 'id' );
  }

  public function clock() {
    return $this->hasMany( 'Clock', 'member_id', 'id' );
  }
}