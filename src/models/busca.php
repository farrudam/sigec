<?php

	$username = 'sati';
        $password = '3czs91ADVuDJBqTW';
        $host = 'localhost';
        $dbname = 'sati_sigec';
        $conn = mysqli_connect($host, $username, $password, $dbname);
	
	//Recuperar o parametro informado no campo input
	$params = $_POST['matricula'];
	
	//Pesquisar no banco de dados o usuário informado
	$usuarios = "SELECT * FROM usuario WHERE matricula LIKE '%$busca%'";
	$resultado_busca = mysqli_query($conn, $params);
	
	if(mysqli_num_rows($resultado_busca) <= 0){
		echo "Nenhum usuário encontrado encontrado...";
	}else{
		while($rows = mysqli_fetch_assoc($resultado_busca)){
			echo "<li>".$rows['nome']."</li>";
		}
	}