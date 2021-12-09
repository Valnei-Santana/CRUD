<?php
class Conexao {
	
	public $conn;
   
   function connect(){
	$servername = "localhost";
	$database = "----";
	$username = "----";
	$password = "----";
	$conn = mysqli_connect($servername, $username, $password, $database);
	return $conn;
   }
}
   ?>