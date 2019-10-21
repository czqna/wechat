<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{url('exam/exam_doliu')}}" method="post">
		@csrf
	<input type="hidden" name="openid" value="{{$req['openid']}}">
	<input type="hidden" name="nickname" value="{{$req['nickname']}}">

	请输出留言<input type="text" name="text"><br>
	<input type="submit" name="" value="提交">
	</form>
</body>
</html>