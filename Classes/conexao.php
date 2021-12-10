<?php
class Conexao {
	
	public $conn;
   
   function connect(){
	$servername = "localhost";
   $database = "valiria";
   $username = "root";
   $password = "l^O3KXFsC#wW";
	$conn = mysqli_connect($servername, $username, $password, $database);
	return $conn;
   }
}
   ?>