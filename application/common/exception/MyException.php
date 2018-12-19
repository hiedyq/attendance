<?php
namespace app\common\exception;

use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\Log;

class MyException extends Handle
{
  protected $errorCodeMsg = [];

  public function render( Exception $e ) {
    $fileName = $e->getFile();
    $line = $e->getLine();
    if ( $e instanceof ValidateException ) {
      $errorMas = $e->getError();
      Log::record( "验证器发生异常：$errorMsg 。[ $fileName $line 行 ]", 'error' );
      return json_code( -1, $errorMsg );
    }
    $errorCode = $e->getCode();
    $errorMsg = isset( $this->errorCodeMsg[$errorCode] ) 
      ? $this->errorCodeMsg[$errorCode] 
      : $e->getMessage();
    Log::record( "执行异常：$errorMsg 。[ $fileName $line 行 ]", 'error' );
    $data = [
      'errorCode' => $errorCode,
      'errorMsg' => $errorMsg,
    ];
    if ( $e instanceof HttpException ) $data['httpStatus'] = $e->getStatusCode();
    return json_code( $errorCode, $errorMsg, $data );
  }
}