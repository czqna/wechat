<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\Wechat;
use Illuminate\Support\Facades\Cache;
use DB;
class ShucaiController extends Controller
{
	public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
   public function add(){
   	return view('shucai.add');

   }
   public function update(Request $request){
   	$req=$request->all();
   	// dd($req['type']);
   	$type_arr=['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
   	$data=$request->file('rsource');
   	// dd($data);
   	$file_ext=$data->getClientOriginalExtension();
   	// dd($file_ext);
   	$flie_name=time().rand(1000,9999).'.'.$file_ext;
   	// dd($flie_name);
   	$path=$request->file('rsource')->storeAS('wechat/'.$req['type'],$flie_name);
   	// dd($path);
      $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->wechat->access_token().'&type='.$req['type'];
      	// dd($url);
 		$data=[
 			'media'=>new \CURLFile(storage_path('app/public/'.$path)),
 		];
 		// dd($data);
 		$re=$this->wechat->wechat_curl_file($url,$data);
 		$result=json_decode($re,1);
 		// dd($result);
 		if (!isset($result['reecode'])) {
 			$res=DB::table('meid')->insert([
 			'media_id'=>$result['media_id'],
 			'type'=>$type_arr[$req['type']],
 			'path'=>$result['url'],
 			'addtime'=>time()

 			]);
 		}
   }
   public function index(){
   	//查询
   	// 	$url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->wechat->access_token();
   	// 	$data=[

		  //   "type"=>'image',
		  //   "offset"=>0,
		  //   "count"=>1-20

   	// 	];
   	// 	$d=$this->wechat->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
  		// $res=json_decode($d,1);
  		// // dd($res);
  		// $type_arr=['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
  		// foreach ($res['item'] as $k => $v) {
  		// $res=DB::table('meid')->insert([
 			// 'media_id'=>$v['media_id'],
 			// 'type'=>$type_arr[$data['type']],
 			// 'path'=>$v['url'],
 			// 'addtime'=>$v['update_time']

 			// ]);

  		// }
   			$req=DB::table('meid')->get();
 		// dd($req);
 			return view('shucai.index',['data'=>$req]);
   }

   //自定义菜单
   public function menu_add(){
   	$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->wechat->access_token();
   	$data=[
	"button"=>[
	     [	
	          "type"=>"click",
	          "name"=>"别摸我",
	          "key"=>"V1001_TODAY_MUSIC"
	      ],
	      [
	           "name"=>"有种点我",
	           "sub_button"=>[
	           [	
	               "type"=>"view",
	               "name"=>"搜索",
	               "url"=>"http://www.baidu.com/"
	            ],
	           
	            [
	               "type"=>"click",
	               "name"=>"赞一下我们",
	               "key"=>"V1001_GOOD"
	            ],
	            [
	               "type"=>"click",
	               "name"=>"碰我",
	               "key"=>"V1001_GOOD"
	            ],

	        ]
	       ]]

   	];

   	$d=$this->wechat->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
  		$res=json_decode($d,1);
  		dd($res);
   }
 
}
