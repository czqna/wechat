<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use DB;
class examController extends Controller
{
	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
 	public function exam_add(){
 		return view('exam.exam_add');
 	}
 	public function exam_doadd(){
 		$url=urlencode(env('APP_URL').'/exam/exam_code');
 		$ur="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".$url."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
 		header('Location:'.$ur);
 	}
 	public function exam_code(Request $request){
 		$data=$request->all();
 		// $session=$request->session()->put('key',$data['code']);
 		
 		$access_token=$this->wechat->access_token();
 		if (empty($data['code'])) {
 			dd('请先授权');
 		}else{
 		$url=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token."&next_openid="
 		);
 		$res=json_decode($url,1);
 		// dd($res['data']);
 	foreach ($res['data']['openid'] as $k => $v) {
		$opid=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$v&lang=zh_CN");
		$info[]=json_decode($opid,1);
			// dd($info);
	}
 		 
 		
 	return	view('exam.exam_code',['data'=>$info]);

 		}
 	}
 	public function exam_liu(Request $request){
 		$req=$request->all();
 		// dd($req);
 		return view('exam.exam_liu',['req'=>$req]);
 	}
 	public function exam_doliu(Request $request){
 		$req=$request->all();
 			// dd($req);
 		// $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->wechat->access_token();
 		// $data=[

		 //   "touser"=>[
		 //    	$req['openid']
		 //   ],
		 //    "msgtype"=> "text",
		 //    "text"=> [ "content"=> $req['text']]
	
 		// ];
 		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->wechat->access_token();
 		$data=[
 			"touser"=>$req['openid'],
           "template_id"=>"DM_sCGhB_Dm6Ng4PdQP6MgwHhAuVdPQi4p20SRexwVI",
             "data"=>[
             		"keyword1"=> [
                      
                       "value"=>$req['nickname']
                   ],
                   "keyword2"=> [
                      
                       "value"=>$req['text']
                   ],
               ]
 		];
 		$re=$this->wechat->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
 		dd($re);
 	}
}
