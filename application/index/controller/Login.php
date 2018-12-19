<?php
namespace app\index\controller;

class Login extends BaseController
{
  private $access_time;
  private $loginName;
  private $password;
  private $ip;
  private $browser;
  
  protected function initialize() {
    //不检查token
    $this->access_time = time();
    $this->loginName = trim( $this->request->post( 'loginName' ) );
    $this->password = $this->request->post( 'password' );
    $this->ip = $this->request->ip();
    $this->browser = get_client_browser();
  }
  
  public function index() {
    
  }
}