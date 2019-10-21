<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{url('exam/exam_doadd')}}" method="post">
	@csrf
	<button>微信授权登录</button>

	</form>
</body>
</html>