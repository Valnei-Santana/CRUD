<?php
header('Content-Type: application/json; charset=utf-8'); // Defino cabeçalho da pagina como JSON
include_once './../Classes/classe.main.php'; // Inclui a classe principal
$i = new Principal(); //Instancia classe Principal
$acao = $_GET['acao']; // Get para as ações que serão utilizadas

if($acao == 'login') {
	$email = $_POST['email']; // Post email 
	$senha = $_POST['senha']; // Post senha
	$senhaSha1 = sha1($senha); // criptografa a senha com sha1
	
	echo $i->Login($email, $senhaSha1);
}

if($acao == 'listAtvd') {
	$tipo = $_POST['tipo']; // Tipo da atividade	
	echo $i->listAtividade($tipo);
}

if($acao == 'addAtvd') {
	$titulo = $_POST['titulo']; // Titulo da atividade
	$desc = $_POST['desc']; // Descrição da atividade
	$tipo = $_POST['tipo']; // Tipo da atividade	
	
	echo $i->addAtividade($titulo, $desc, $tipo);
}

if($acao == 'editAtvd') {
	$id = $_POST['id']; // Chave da atividade que deseja editar
	$titulo = $_POST['titulo']; // Titulo da atividade
	$desc = $_POST['desc']; // Descrição da atividade
	$tipo = $_POST['tipo']; // Tipo da atividade	
	
	echo $i->editAtividade($id, $titulo, $desc, $tipo);
}

if($acao == 'getEdit') {
	$id = $_POST['id']; // Chave da atividade que deseja editar

	echo $i->getAtividade($id);
}

if($acao == 'deleteAtvd') {
	$id = $_POST['id']; // Chave da atividade que deseja editar

	echo $i->removeAtividade($id);
}

if($acao == 'fimAtvd') {
	$id = $_POST['id']; // Chave da atividade que deseja editar

	echo $i->fimAtividade($id);
}
?>