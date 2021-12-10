<?php
include_once './conexao.php';
//Set linguagem PT
setlocale(LC_TIME, 'pt');

class Principal {
	public $conn;
	
	function Login($email, $senha) {
		//Querys para checar se email e senha confere, SE sim retornar TRUE caso contrario FALSE
	}
	
	function addAtividade($titulo, $desc, $tipo) {
	// Variaveis data atual e horario atual
	 $data = date('d-m-Y', time());
     $diaSemana = strftime("%A", strtotime($data));
	 $horario = date('Hi', time());
	 
	 //Condicional: SE for tipo 4 E sexta-feira E o horario maior que a 13:00 definir state FALSE.
	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
		
		$result = ["state" => 'false'];
	 
	 } else {
		  
		  //Querys para adicionar a database e definir state true
		  
		$result = ["state" => 'true'];
	 }
		return json_encode($result);
	}
	
	function listAtividade($tipo) {
		
		//Condicional: SE tipo for 0 listar as de tipo: 1, 2, 3 e 4 (ABERTAS)

		//Tipo 1: Desenvolvimento | Tipo 2: Atendimento | Tipo 3: Manutenção | Tipo 4: Manutenção urgente | Tipo 5: Concluída 
		
		//Querys para adicionar a database e retornar true
	}
	
	function editAtividade($id, $titulo, $desc, $tipo) {

	 // Variaveis data atual e horario atual
	 $data = date('d-m-Y', time());
     $diaSemana = strftime("%A", strtotime($data));
	 $horario = date('Hi', time());
	 
	 //Condicional: SE for tipo 4 E sexta-feira E o horario maior que a 13:00 definir state FALSE.
	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
		
		$result = ["state" => 'false'];
	 
	 } else {
		
		//Query para editar a atividade de ID correspondente ao passado, ao finalizar definir state TRUE  
		$result = ["state" => 'true'];
		
	 }
		return json_encode($result);
		
	}
	
	function removeAtividade($id) {
		//Query para puxar informações do ID solicitado $tipo é definido através dessa consulta
		
		//Condicional: SE atividade for tipo 4 definir stete FALSE.
		if($tipo == 4) {
		
		$result = ["state" => 'false'];
	 
		} else {
		
		//Query para remover atividade do ID solicitado e definir state TRUE  
		$result = ["state" => 'true'];
		
		}
		
		return json_encode($result);
		
	}
	
	function fimAtividade($id) {
		//Query para puxar informações do ID solicitado $desc é definido através dessa consulta
		
		//Condicional: SE descrição for menor que 50 caracteres retornar FALSE
		if(strlen($desc) < 50) {
		
		$result = ["state" => 'false'];
	 
		} else {
		
		//Query para remover atividade do ID solicitado e definir state TRUE  
		$result = ["state" => 'true'];
		
		}
		
		return json_encode($result);
		//Query para finalizar uma atividade, ao finalizar retornar TRUE
		
	}
}
?>