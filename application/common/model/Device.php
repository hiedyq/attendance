<?php
namespace app\common\model;

class Device extends BaseModel
{
  public function department() {
    return $this->belongsTo( 'Department', 'department_id', 'id' );
  }
}