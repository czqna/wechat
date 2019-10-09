<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table border="1">
	<tr>
		<td>图片</td>
		<td>名称</td>
		<td>城市</td>
		<td>opid</td>
		
	</tr>
	@foreach ($info as $v)
	<tr>
		<td><img src="{{$v['headimgurl']}}"></td>
		<td>{{$v['nickname']}}</td>
		<td>{{$v['openid']}}</td>
		<td>{{$v['openid']}}</td>
		
	</tr>
	@endforeach
	</table>
</body>
</html>