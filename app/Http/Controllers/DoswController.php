<?php

namespace App\Http\Controllers;
// use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use DB;
class 	DoswController extends Controller
{
	// public $wechat;
 //    public function __construct(Wechat $wechat)
 //    {
 //        $this->wechat = $wechat;
 //    }
    public function event(){
    	 $info=file_get_contents("php://input");
    	 // dd($info);
      //吧接受微信的xml数据存入日志
      file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
      file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),$info."\n",FILE_APPEND);
      //解析xml
      $xml_obj=simplexml_load_string($info,'SimpleXMLELement',LIBXML_NOCDATA);
      $xml_arr=(array)$xml_obj;
      $req=$this->get_wechat_user($xml_arr['FromUserName']);
      // dd($req);
      if ($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe') {
      	$data=DB::table('dodo')->get();
    	if ($data) {
    		$data=[
    			'openid'=>$req['openid'],
    			'name'=>$req['nickname']
    		];
    		$re=DB::table('dodo')->insert($data);
    		     $msg=$msg="你好".$req['nickname']."欢迎关注本公众号";
      		echo "<xml>
			<ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
			<FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
			<CreateTime>".time()."</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[".$msg."]]></Content>
			</xml>
				";
    	}else{
    			$msg=$msg="你好".$req['nickname']."欢迎回到本公众号";
      		echo "<xml>
			<ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
			<FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
			<CreateTime>".time()."</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[".$msg."]]></Content>
			</xml>
				";
	
    	}

      }
      if ($xml_arr['MsgType']=='text' && $xml_arr['Content']=='图文') {
      			$msg=$msg="你好".$req['nickname']."我能收到你发的消息";
      		echo "<xml>
			<ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
			<FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
			<CreateTime>".time()."</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[".$msg."]]></Content>
			</xml>
				";
      }
      if ($xml_arr['MsgType']=='text' && $xml_arr['Content']=='天气') {
      		$ur=file_get_contents("http://api.k780.com/?app=weather.future&weaid=1&appkey=46237&sign=b028a01cb3d8a2b9e7c895bb5829d2b0&format=json");
      		$tian=json_decode($ur,1);
      		// dd($tian);
      		foreach ($tian['result'] as $k => $v) {
      				// dd($v);
      			$msg=$v['days'].",".$v['citynm'].",".$v['week'].",".$v['temperature'].",".$v['weather'];
      			// dd($msg);
      		echo "<xml>
			<ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
			<FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
			<CreateTime>".time()."</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[".$msg."]]></Content>
			</xml>
				";

      		}
      		
      }
    }
    public function get_wechat_user($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token().'&openid='.$openid.'&lang=zh_CN';
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return $result;
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
}
