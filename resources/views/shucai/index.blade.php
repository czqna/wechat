<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<table border="1">
		<tr>
			<td>id</td>
			<!-- <td>地址</td> -->
			<td>时间</td>
			<td>media_id</td>
			
			<td>操作</td>
		</tr>
	@foreach ($data as $v)
		<tr>
			<td>{{$v->id}}</td>
			<!-- <td>{{$v->path}}</td> -->
			<td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
			<td>{{$v->media_id}}</td>
		
			<td></td>
		</tr>
		@endforeach
	</table>
</body>
</html>