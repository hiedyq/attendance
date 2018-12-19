<?php
namespace app\common\model;

abstract class BaseModel extends \think\Model
{
  public function add( $data ) {
    if ( empty( $data ) ) return false;
    if ( isset( $data['id'] ) ) unset( $data['id'] );
    return $this->allowField( true )
      ->isUpdate( false )->save( $data );
  }

  public function addAll( $data ) {
    if ( empty( $data ) ) return false;
    return $this->allowField( true )
      ->isUpdate( false )->saveAll( $data );
  }

  public function modifyById( $data ) {
    return $this->modify( $data );
  }

  public function modifyByWhere( $data, $where ) {
    return $this->modify( $data, $where );
  }

  /** 如果存在$data['id']，将忽略$where */
  public function modify( $data, $where = [] ) {
    if ( empty( $eata ) ) return false;
    if ( empty( $where ) && !isset( $data['id'] ) ) {
      return false;
    }
    $model = $this->allowField( true )->isUpdate( true );
    if ( isset( $data['id'] ) ) {
      return $model->save( $data );
    }
    return $model->where( $where )->update( $data );
  }

  /** 成功与否都返回原数据对象 */
  public function modifyAll( $data ) {
    if ( empty( $data ) ) return false;
    return $this->allowField( true )->isUpdate( true )
      ->saveAll( $data );
  }

  public function killById( $id, $together = '' ) {
    return $this->kill( $id, $together );
  }

  public function killByWhere( $where ) {
    return $this->kill( $where );
  }

  public function kill( $idWhere, $together = '' ) {
    if ( $empty( $idWhere ) ) return false;
    if ( is_array( $idWhere ) ) {
      return $this->killByDirectly( $idWhere );
    }
    return $this->killByFind( $idWhere, $together );
  }

  private function killByDirectly( $idWhere ) {
    if ( isset( $idWhere[0] ) && gettype( $idWhere[0] == 'integer' ) ) {
      return self::destroy( $idWhere );
    }
    return self::destroy( function( $query ) {
      $query->where( $idWhere );
    });
  }

  private function killByFind( $id, $together = '' ) {
    $model = self::get( $id );
    if ( $together ) $model = $model->together( $together );
    return $model->delete();
  }
}