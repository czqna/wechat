<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use DB;
class EventController extends Controller
{
	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
	public function index(Request $request){
		$access_token=$this->wechat->access_token();
	
	$info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=");
		// dd($info);
		$in=json_decode($info,1);
		$info=[];
		// dd($info);
		foreach ($in['data']['openid'] as $k => $v) {
		$opid=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$v&lang=zh_CN");
		$info[]=json_decode($opid,1);
		// dd($info);
		// $data=[
		// 		'openid'=>$re['openid'],
		// 		'city'=>$re['city'],
		// 		'nickname'=>$re['nickname'],
		// 		'headimgurl'=>$re['headimgurl']
		// ];
		// $res=DB::table('wechat')->insert($data);
		
	
			}
			// dd($info);
		return view('wechat.index',['info'=>$info]);
			
	}

  
}
