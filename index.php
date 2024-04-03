<?php

	include('config/db_connect.php');

	$sql = 'SELECT id, title, sub, time, creator, text, idChar, imgType FROM main ORDER BY id DESC';
	$result = mysqli_query($conn, $sql);
	$news = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	mysqli_close($conn);

?>

<?php include('templates/header.php'); ?>

<main>
	<?php foreach($news as $gamenews): ?>
		<ul>
			<li class="container">
				<a href="details.php?id=<?php echo $gamenews['id'] ?>">
					<section id="left">
						<img id="front" src="/img/<?php echo $gamenews['idChar'].'.'. $gamenews['imgType'] ?>">
					</section>
					<section id="right">
						<h2><?php echo $gamenews['title'] ?></h2>
						<h3><?php echo $gamenews['sub'] ?></h3>
						<p>Escrito por <?php echo $gamenews['creator'] ?></p>
					</section>
				</a>
			</li>
		</ul>
	<?php endforeach; ?>
</main>

<?php include('templates/footer.php'); ?>