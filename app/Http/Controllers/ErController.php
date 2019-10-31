<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use DB;
class ErController extends Controller
{

	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
    public function index(){
    	$req=DB::table('wechat')->get();
    	// dd($req);
    	return view('er/index',['data'=>$req]);
    }
    public function add(Request $request){
    	$req=$request->all();
    	$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->wechat->access_token();
    	$data=[
    		'expire_seconds'=> 30 * 24 * 3600,
            'action_name'=>'QR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$req['openid']
                ]
            ]

    	];
    	dd($data);
    }
}
