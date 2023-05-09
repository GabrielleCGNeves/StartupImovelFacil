<?php 

	require_once 'controllers/environment.php';


	$server_name = 'localhost';
	$user_name = 'root';
	$password = '';
	$db_name = 'imovelfacil';

	$conn = mysqli_connect($server_name,$user_name,$password,$db_name); //creating a conection

	mysqli_set_charset($conn,"utf8");

	if (mysqli_connect_error()) {
		echo "Erro ao conectar com o banco de dados" .mysqli_connect_error();
	} else {
		echo "Conectado com sucesso\n";
	}
?>