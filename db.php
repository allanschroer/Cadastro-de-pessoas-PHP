<?php

$servidor = 'localhost';
$db = 'cadastro_adsomos';
$db_user = 'adsomos';
$db_pass = '123';


//conexão com o servidor mysql
$conexao = mysqli_connect($servidor, $db_user, $db_pass, $db);

//consulta do DB para exibição na tela principal
$query = "SELECT * FROM cadastro";
$exibicao = mysqli_query($conexao, $query);
