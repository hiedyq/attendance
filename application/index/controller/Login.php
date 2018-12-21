<?php
namespace app\index\controller;

use app\common\model\Token;

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
    if ( !$this->loginName ) { exception( '用户名不能为空', -2 ); }
    $where = [
      'loginName' => $this->loginName,
      'password' => $this->password,
    ];
    $rs = \app\common\model\User::with( 'shop' )
      ->where( $where )->find();
    $rs = checkObject2array( $rs );
    if ( empty( $rs ) ) { exception( '用户名或密码错误', -3 ); }
    if ( $rs['enable'] != 1 ) { exception( '该用户未被启用', -4 ); }
    $this->companyId = $rs['companyId'];
    $token = md5( $this->ip.$this->browser.$access_time );
    if ( !$success = $this->recordLogin2token( $rs['id'], $token ) ) {
      exception( '因为系统原因，登录没有被成功记录', -5 );
    }
    $returnData = $this->returnLoginData( $rs, $token );
    return json_code( 1, '登录成功', $returnData );
  }

  //记录用户登录到token
  private function recordLogin2token( $userId, $token ) {
    $data = [
      'user_id' => $userId,
      'ip' => $this->ip,
      'browser' => $this->browser,
      'token' => $token,
      'access_time' => $this->access_time,
    ];
    return Token::create( $data );
  }

  //返回登录数据
  private function returnLoginData( $rs, $token ) {
    $returnData = [
      'token' => $token,
      'userId' => $rs['id'],
      'loginName' => $rs['login_name'],
      'realName' => $rs['real_name'],
      'companyId' => $rs['company_id'],
      'shopId' => $rs['shop_id'],
      'shopName' => $rs['shop_name'],
      'shopAll' => $rs['shop_all'],
      'shops' => [],
    ];
    if ( $rs['shop_all'] != 0 ) {
      $shopRs = \app\common\model\Shop::select();
      $shopRs = checkObject2array( $shopRs );
      if ( !empty( $shopRs ) ) {
        $returnData['shops'] = array_column( $shopRs, 'id' );
      }
    }
    return $returnData;
  }

  public function checkLogin() {
    $data = [
      'name' => 'abc',
      'roles' => [ '' ],
      'data' => [],
    ];
    if ( !$this->token ) {
      return json_code( -1, '缺失token', $data );
    }
    $loginResult = $this->getLoginDataByToken( $$this->token );
    $code = isset( $loginResult['code'] ) ? $loginResult['code'] : 0;
    $msg = isset( $loginResult['msg'] ) ? $loginResult['msg'] : '登录检查没有通过';
    $loginData = isset( $loginResult['data'] ) ? $loginResult['data'] : [];
    if ( $code == 1 ) {
      $data['roles'] = $loginData['shopAll'] == 1 ? ['admin'] : ['user'];
      $returnData = [
        'name' => $loginData['loginName'],
        'roles' => $data['roles'],
      ];
      $data['data'] = array_merge( $returnData, $loginData );
    }
    return json_code( $code, $msg, $data );
  }

  //通过token获取登录用户数据
  private function getLoginDataByToken( $token ) {
    $rs = Token::where( 'token', $token )->find();
    $rs = checkObject2array( $rs );
    $returnData = [ 'token' => $token, 'loginName' => '' ];
    if ( empty( $rs ) ) {
      return code_array( -2, 'token已不存在，请重新登录', $returnData );
    }
    $userRs = \app\common\model\User::with( 'shop' )
      ->find( $rs['user_id'] );
    $userRs = checkObject2array( $userRs );
    if ( empty( $userRs ) ) {
      return code_array( -3, '用户已不存在', $returnData );
    }
    $returnData['loginName'] = $userRs['login_name'];
    if ( $rs['ip'] != $this->ip || $rs['browser'] != $this->browser ) {
      return code_array( -4, '登录地点错误', $returnData );
    }
    $this->companyId = $userRs['company_id'];
    $loginData = $this->returnLoginData( $userRs, $token );
    $returnData = array_merge( $returnData, $loginData );
    return code_array( 1, '检查通过', $returnData );
  }

  public function logout() {
    if ( !$this->token ) { exception( '没有token', -2 ); }
    $success = Token::where( 'token', $this->token )->delete();
    if ( $success === false ) { exception( '退出失败', -3 ); }
    if ( $seccess == 0 ) { exception( '没有可退出的token', -4 ); }
    return json_code( 1, '退出成功' );
  }
}