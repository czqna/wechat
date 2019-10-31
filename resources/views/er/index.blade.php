<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>列表</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>id</td>
			<td>用户id</td>
			<td>用户名称</td>
			<td>二维码</td>
		
		</tr>
		@foreach ($data as $v)
		<tr>
			<td>{{$v->id}}</td>
			<td>{{$v->openid}}</td>
			<td>{{$v->nickname}}</td>	
			<td><a href="{{url('er/add')}}?openid={{$v->id}}">生成二维码</a></td>
			
		</tr>
	@endforeach

	</table>
</body>
</html>