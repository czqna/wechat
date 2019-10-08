<?php

namespace  App\Http\Tool;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class Wechat{

 public function access_token(){

   	if (Cache::pull('access_token_key')) {
   		//有的话去缓存拿
  		$access_token=Cache::push('access_token');
  		echo $access_token;
   	}else{
   		//没有通过微信接口拿
   		$access_toke=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
   		// dd($access_token);
   		$access_re=json_decode($access_toke,1);
   		// dd($access_re);
   		$access_token=$access_re['access_token'];
   		$expires_in=$access_re['expires_in'];
   		//加入缓存
   		Cache::put('access_token_key',$access_token,now()->addMinutes($expires_in));
   		// dd($a);
   	}
   	return $access_token;
   	// $seconds=21;
   	// Cache::put('access_token',$seconds);
   	// $value = Cache::pull('access_token');
   	// Cache::forget('access_token');
   	// echo $value;
   	
   }
}