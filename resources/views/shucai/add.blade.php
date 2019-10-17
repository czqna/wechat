<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>素材添加</title>
</head>
<body>
	<form action="{{url('shucai/update')}}" method="post" enctype="multipart/form-data">
			@csrf
		<select name="type">
			<option value="image">图片</option>
			<option value="voice">视频</option>
			<option value="video">音频</option>
			<option value="thumb">缩略图</option>
		</select><br>
		<input type="file" name="rsource"><br>
		<input type="submit" value="提交">	
	</form>
</body>
</html>