<?php
namespace app\common\model;

class DepartmentScheduling extends BaseModel
{
  public function department() {
    return $this->belongsTo( 'Department', 'department_id', 'id' );
  }

  public function scheduling() {
    return $this->belongsTo( 'Scheduling', 'scheduling_id', 'id' );
  }
}