<?php

namespace  App\Http\Tool;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class Wechat{
	//标签列表
	  public function label_lists(){

  		$data='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->access_token();
  		// dd($data);
  		// 
  		$d=$this->curl_get($data);
  		// dd($d);
  		$do=json_decode($d,1);
  		// dd($do);
  		return $do;
  }

 public function access_token(){

   	if (Cache::has('access_token_key')) {
   		//有的话去缓存拿
   		// dd(Cache::has('access_token_key'));
  		$access_token=Cache::get('access_token_key');
  		// echo $access_token;
  		
   	}else{
   		//没有通过微信接口拿
   		$access_toke=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
   		// dd($access_token);
   		$access_re=json_decode($access_toke,1);
   		// dd($access_re);
   		$access_token=$access_re['access_token'];
   		$expires_in=$access_re['expires_in'];
   		//加入缓存
   		Cache::put('access_token_key',$access_token,$expires_in);
   		// dd($a);
   	}
   	return $access_token;
  
   	
   }
   //curl发送post
   public function curl_post($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
       //curl发送get
     public function curl_get($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    	//获取用用户基本信息
       public function get_wechat_user($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token().'&openid='.$openid.'&lang=zh_CN';
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return $result;
    }

        public function wechat_curl_file($url,$data)
    {
       $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function do_event(){
          $info=file_get_contents("php://input");
      //吧接受微信的xml数据存入日志
      file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
      file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),$info."\n",FILE_APPEND);
      //解析xml
      $xml_obj=simplexml_load_string($info,'SimpleXMLELement',LIBXML_NOCDATA);
      $xml_arr=(array)$xml_obj;
      $req=$this->wechat->get_wechat_user($xml_arr['FromUserName']);
      return $req;
    }
    public function nowapi_call($a_parm){
    if(!is_array($a_parm)){
        return false;
    }
    //combinations
    $a_parm['format']=empty($a_parm['format'])?'json':$a_parm['format'];
    $apiurl=empty($a_parm['apiurl'])?'http://api.k780.com/?':$a_parm['apiurl'].'/?';
    unset($a_parm['apiurl']);
    foreach($a_parm as $k=>$v){
        $apiurl.=$k.'='.$v.'&';
    }
    $apiurl=substr($apiurl,0,-1);
    if(!$callapi=file_get_contents($apiurl)){
        return false;
    }
    //format
    if($a_parm['format']=='base64'){
        $a_cdata=unserialize(base64_decode($callapi));
    }elseif($a_parm['format']=='json'){
        if(!$a_cdata=json_decode($callapi,true)){
            return false;
        }
    }else{
        return false;
    }
    //array
    if($a_cdata['success']!='1'){
        echo $a_cdata['msgid'].' '.$a_cdata['msg'];
        return false;
    }
    return $a_cdata['result'];
}

$nowapi_parm['app']='weather.future';
$nowapi_parm['weaid']='1';
$nowapi_parm['appkey']='APPKEY';
$nowapi_parm['sign']='SIGN';
$nowapi_parm['format']='json';
$result=nowapi_call($nowapi_parm);
  return $result;
}
}