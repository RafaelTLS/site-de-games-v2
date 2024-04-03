<?php 

include('config/db_connect.php');

//---------------

$n=7;
function getRand($n) {
	$seed = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
	$rand = '';

	for ($i=0; $i < $n; $i++) { 
		$index = rand(0, strlen($seed) - 1);
		$rand .= $seed[$index];
	}
	return $rand;
}

//----------------

$title = $sub = $creator = $text = $imagedesc = '';
$idChar = getRand($n);
$error = array('title'=>'','sub'=>'', 'creator'=>'', 'text'=>'', 'image'=>'', 'imagedesc'=>'');

if(isset($_POST['submit'])) {
	if(empty($_POST['title'])) {
		$error['title'] = 'Um título é requerido.';
	} else {
		$title = $_POST['title'];
	}
	if(empty($_POST['sub'])) {
		$error['sub'] = 'Um subtítulo é requerido.';
	} else {
		$sub = $_POST['sub'];
	}
	if(empty($_POST['creator'])) {
		$error['creator'] = "Um nome é requerido.";
	} else {
		$creator = $_POST['creator'];
	}
	if(empty($_POST['text'])) {
		$error['text'] = "Um texto é requerido.";
	} else {
		$text = preg_replace("/<a(.*)<\/a>/iUs", "", $_POST['text']);
	}
	if((empty($_POST['imagedesc'])) && (($_FILES['image']['error']) === 0)) {
		$error['imagedesc'] = "A imagem necessita de descrição.";
	} elseif ((($_FILES['image']['error']) > 0) && ($_POST['imagedesc'])) {
		$error['image'] = "É necessária uma imagem para a descrição.";
	} else {
		$imagedesc = $_POST['imagedesc'];
	}


	//------------------

	function resize($imgid, $imgwidth, $imgheight) {
		$targetwidth = 500;
		$targetheight = 380;
		$target = imagecreatetruecolor($targetwidth, $targetheight);
		imagecopyresampled($target, $imgid, 0, 0, 0, 0, $targetwidth, $targetheight, $imgwidth, $imgheight);
		return $target;
	}

	if(is_array($_FILES) && (empty(array_filter($error)))) {
		$uploaded = $_FILES['image']['tmp_name'];
		$properties = getimagesize($uploaded);
		$folder = './img/';
		$imgext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		$imgtype = $properties[2];

		switch ($imgtype) {
			case IMAGETYPE_PNG:
				$imgid = imagecreatefrompng($uploaded);
				$target = resize($imgid, $properties[0], $properties[1]);
				imagepng($target, $folder . $idChar . '.' . $imgext);
				break;

			case IMAGETYPE_GIF:
				$imgid = imagecreatefromgif($uploaded);
				$target = resize($imgid, $properties[0], $properties[1]);
				imagegif($target, $folder . $idChar . '.' . $imgext);
				break;

			case IMAGETYPE_JPEG:
				$imgid = imagecreatefromjpeg($uploaded);
				$target = resize($imgid, $properties[0], $properties[1]);
				imagejpeg($target, $folder . $idChar . '.' . $imgext);
				break;

			default:
				echo "PNG, GIF or JPEG only.";
				exit;
				break;

			move_uploaded_file($uploaded, $folder.$idChar. '.' .$imgext);
		}
	}

	//------------------

	$search = array('b**', '**b', 'i**', '**i', 'a**', '++', '**a');
	$replace = array('<b>', '</b>', '<i>', '</i>', '<a href="', '">', '</a>');
	$txtreplace = str_replace($search, $replace, $text);

	//------------------

	if(array_filter($error)) {
		echo 'Erro no upload.';
	} else {
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$sub = mysqli_real_escape_string($conn, $_POST['sub']);
		$creator = mysqli_real_escape_string($conn, $_POST['creator']);
		$text = mysqli_real_escape_string($conn, $txtreplace);
		$imagedesc = mysqli_real_escape_string($conn, $_POST['imagedesc']);

		//-----------

		$sql = "INSERT INTO main(idChar, title, sub, creator, text, imgType, imagedesc) VALUES('$idChar', '$title', '$sub', '$creator', '$text', '$imgext', '$imagedesc')";

		if(mysqli_query($conn, $sql)) {
			header('location: index.php');
		} else {
			echo 'Ocorreu um erro: ' . mysqli_error($conn);
		}
	}
}

?>

	<?php include('templates/header.php') ?>

<main>
	<h3>Adicionar:</h3>
	<form action="add.php" method="POST" enctype="multipart/form-data">
		<label for="title">Título:</label>
		<input type="text" id="title" name="title" value="<?php echo $title ?>">
		<span><?php echo $error['title']; ?></span><br>
		<label for="sub">Subtítulo:</label>
		<input type="text" id="sub" name="sub" value="<?php echo $sub; ?>">
		<span><?php echo $error['sub']; ?></span><br>
		<label for="image">Imagem:</label>
		<input type="file" id="image" name="image" accept="image/*">
		<span><?php echo $error['image'] ?></span><br>
		<label for="imagedesc">Descrição da imagem:</label>
		<input type="text" id="imagedesc" name="imagedesc" value="<?php echo $imagedesc ?>">
		<span><?php echo $error['imagedesc'] ?></span><br>
		<label for="text">Texto:</label>
		<textarea name="text" id="text"><?php echo $text ?></textarea>
		<span><?php echo $error['text'] ?></span><br>
		<label for="creator">Criado por:</label>
		<input type="text" id="creator" name="creator" value="<?php echo $creator ?>">
		<span><?php echo $error['creator'] ?></span><br>
		<input type="submit" name="submit" value="Enviar">
	</form>
</main>

	<?php include('templates/footer.php') ?>