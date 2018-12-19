<?php
namespace app\common\model;

class Ruler extends BaseModel
{
  public function scheduling() {
    return $this->belongsTo( 'Scheduling', 'scheduling_id', 'id' );
  }
}