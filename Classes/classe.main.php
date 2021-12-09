<?php
include_once './conexao.php';

class Principal {
	public $conn;
	
	function Login($email, $senha) {
		//Querys para checar se email e senha confere, SE sim retornar TRUE caso contrario FALSE
	}
	
	function addAtividade($titulo, $desc, $tipo) {
		//Condicional: SE for sexta-feira e o horario maior igual a 13:00 retornar FALSE.
		
		//Querys para adicionar a database e retornar true
		
	}
	
	function listAtividade($tipo) {
		
		//Condicional: SE tipo for 0 listar as de tipo: 1, 2, 3 e 4 (ABERTAS)

		//Tipo 1: Desenvolvimento | Tipo 2: Atendimento | Tipo 3: Manutenção | Tipo 4: Manutenção urgente | Tipo 5: Concluída 
		
		//Querys para adicionar a database e retornar true
	}
	
	function editAtividade($id, $titulo, $desc, $tipo) {
		
		//Condicional: SE for sexta-feira e o horario maior igual a 13:00 retornar FALSE.
		
		//Query para editar a atividade de ID correspondente ao passado, ao finalizar retornar TRUE
		
	}
	
	function removeAtividade($id) {
		
		//Condicional: SE atividade for tipo 4 retornar FALSE.
		
		//Query para remover a atividade de ID correspondente ao passado, ao finalizar retornar TRUE
		
	}
	
	function fimAtividade($id) {
		//Condicional: SE descrição for menor que 50 caracteres retornar FALSE
		
		//Query para finalizar uma atividade, ao finalizar retornar TRUE
		
	}
}
?>