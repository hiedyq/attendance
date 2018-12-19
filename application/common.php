<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function allow_domain_header() {
  $allow_domain = config( 'app_debug' ) ? config( 'local_allow_domain' ) 
    : config( 'remote_allow_domain' );
  header( "Access-Control-Allow-Origin: $allow_domain" );
  header( 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS' );
  header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, x-token' );
  header( 'Access-Control-Allow-Credentials: true' );
}

function api_code( $data = [] ) {
  if ( is_object( $data ) ) $data = $data->toArray();
  if ( empty( $data ) ) {
    return json_code( 1, '成功', [] );
  }
  $code = isset( $data['code'] ) ? $data['code'] : 1;
  $msg = isset( $data['msg'] ) ? $data['msg'] : '成功';
  if ( isset( $data['data'] ) ) { $data = $data['data']; }
  return json_code( $code, $msg, $data );
}

function json_code( $code = 0, $msg = '', $data = [] ) {
  return json( code_array( $code, $msg, $data ) );
}

function code_array( $code = 0, $msg = '', $data = [] ) {
  return [
    'code' => $code,
    'msg' => $msg,
    'data' => $data,
  ];
}

/**
* 获取客户端浏览器类型
* @param  string  $glue   浏览器类型和版本号之间的连接符
* @return string
*/
function get_client_browser( $glue = '' ) {
  $browser = [];
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $regex = array(
      'ie'      => '/(MSIE) (\d+\.\d)/',
      'chrome'  => '/(Chrome)\/(\d+\.\d+)/',
      'firefox' => '/(Firefox)\/(\d+\.\d+)/',
      'opera'   => '/(Opera)\/(\d+\.\d+)/',
      'safari'  => '/Version\/(\d+\.\d+\.\d) (Safari)/',
  );
  foreach( $regex as $type => $reg ) {
      preg_match( $reg, $agent, $data );
      if( !empty( $data ) && is_array( $data ) ) {
          $browser = $type === 'safari' ? [ $data[2], $data[1] ] : [ $data[1], $data[2] ];
          break;
      }
  }
  $returnBrowser = implode( $glue, $browser );
  return $returnBrowser ? $returnBrowser : 'unknow';
}
