<?php
	
	//Variável de conexão
	$conn = 'mysql:host=localhost;dbname=curso_pdo_25_03_2015';

	//Tratamento de erros
	try{
		$db = new PDO($conn, 'root', '');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch (PDOException $e){
		if($e->getCode() == 1049){
			echo "Banco de dados errado";
		}
		echo $e->getMessage();
	}
?>