<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="utf-8">
	<title></title>
	@include("admin.layout.styles")
</head>

<body>
	<header></header>
	<main>
		@yield("content")
	</main>
	<footer></footer>

	@include("admin.layout.scripts")
</body>

</html>