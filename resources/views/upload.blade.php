<!DOCTYPE html>
<html>
<head>
	<title>Million of data upload</title>
</head>
<body>
	<form method="POST" action="{{ 'upload' }}" enctype="multipart/form-data">
		@csrf
		<input type="file" name="mycsv" id="mycsv">
		<input type="submit" value="upload">
	</form>
</body>
</html>