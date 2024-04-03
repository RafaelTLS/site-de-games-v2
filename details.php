<?php 

	include('config/db_connect.php');

	if(isset($_GET['id']) && ctype_digit($_GET['id'])) {
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM main WHERE id = $id";

		$result = mysqli_query($conn, $sql);

		$news = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
	}
	
	mysqli_close($conn);

?>
	
	<?php include('templates/header.php') ?>
	
	<main>
		<article>
			<?php if(isset($news)): ?>
				<h2><?php echo $news['title'] ?></h1>
				<h3><?php echo $news['sub'] ?></h2>
				<p>Escrito por <?php echo $news['creator'] ?> em <?php echo date('d/m/Y, H:i', strtotime($news['time'])) ?>.</p>
				<figure>
					<img src="/img/<?php echo $news['idChar'] ?>.<?php echo $news['imgType']?>">
					<figcaption><?php echo $news['imagedesc'] ?></figcaption>
				</figure>
				<p id="text"><?php echo nl2br($news['text']) ?></p>
			<?php else: ?>
				<p>Não existe nada aqui!</p>
				<a href="#" onclick="history.back();">Voltar à página anterior.</a>
			<?php endif; ?>
		</section>
	</main>

	<?php include('templates/footer.php') ?>