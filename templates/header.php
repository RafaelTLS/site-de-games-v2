<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if (isset($_GET['id'])): ?>
		<title><?php echo $news['title'] ?> - Site de Games</title>
	<?php else: ?>
		<title>Site de Games</title>
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="css/css.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<h1 id="header"><a href="/">Masturbyte</a></h1>
	</header>