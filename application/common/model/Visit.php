<?php
namespace app\common\model;

class Visit extends BaseModel
{
  public function member() {
    return $this->belongsTo( 'Member', 'member_id', 'id' );
  }
}