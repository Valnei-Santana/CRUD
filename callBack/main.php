<?php
include_once './../Classes/classe.main.php'; // Inclui a classe principal
$i = new Principal(); //Instancia classe Principal
$acao = $_GET['acao']; // Get para as ações que serão utilizadas

if($acao == 'login') {
	$email = $_POST['email']; // Post email 
	$senha = $_POST['senha']; // Post senha
	$senhaSha1 = sha1($senha); // criptografa a senha com sha1
	
	echo $i->Login($email, $senhaSha1);
}
?>