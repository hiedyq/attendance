<?php
namespace app\index\controller;

abstract class BaseController extends \think\controller
{
  protected $token;
  protected $companyId;
  protected $shopId;

  public function __construct( Request $request ) {
    allow_domain_header();
    if ( $request->method() == 'OPTIONS' ) {
      die;
    }
    if ( !$this->token = $request->param( 'token' ) ) {
      $this->token = $request->header( 'x-token' );
    }
    $this->companyId = $request->post( 'companyId' );
    $this->shopId = $request->post( 'shopId' );
    parent::__construct();
  }

  public function checkToken() {
    if ( !config( 'check_token' ) ) { return true; }
    if ( !$this->token ) { exception( '没有传递有效的token', 0 ); }
    //todo::
    return true;
  }
}