<?php
namespace app\common\model;

class Clock extends BaseModel
{
  public function member() {
    return $this->belongsTo( 'Member', 'member_id', 'id' );
  }

  public function scheduling() {
    return $this->belongsTo( 'Scheduling', 'scheduling_id', 'id' );
  }
}