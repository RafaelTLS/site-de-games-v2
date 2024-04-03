<?php 

	//conectar
	$conn = mysqli_connect('localhost:3306', 'root', '', 'sitedegames');

	//checar conexão
	if(!$conn) {
		echo 'erro: ' . mysqli_connect_error();
	}
	
?>