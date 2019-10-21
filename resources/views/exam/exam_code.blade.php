<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table border="1">
	<tr>
		<td>用户名称</td>
		<td>opid</td>
		<td>给用户留言</td>
		
	</tr>
	@foreach ($data as $v)
	<tr>
		<td>{{$v['nickname']}}</td>
		<td>{{$v['openid']}}</td>
		<td><a href="{{url('exam/exam_liu')}}?openid={{$v['openid']}}&nickname={{$v['nickname']}}">给用户留言</a></td>
	</tr>
	@endforeach
	</table>
</body>
</html>