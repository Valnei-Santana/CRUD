<?php
// Inclusão da conexão MySQL
require_once('conexao.php');
//Set linguagem PT
setlocale(LC_TIME, 'pt');

// Set timezone SP
date_default_timezone_set('America/Sao_Paulo');

// Variaveis data atual e horario atual que serão usadas
$data = date('d-m-Y', time());
$diaSemana = strftime("%A", strtotime($data)); // %A = dia da semana
$horario = date('Hi', time()); // H = Horario | i = minuto

class Principal {
	
	public function Login($email, $senha) {
		// Variavel global de conexao
		global $conn;
		
		//Query verificação email e senha
		$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND senha = ?"); // Prepara consulta
		$stmt->bind_param('ss', $email, $senha); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$stmt->store_result();
		$row_cnt = $stmt->num_rows; // Numero de linhas encontradas na consulta (banco)
		if($row_cnt > 0) { // Se possuir registro continua e retorna TRUE, caso contrario FALSE
			session_start(); // Inicia uma sessão
			$_SESSION['email'] = $email; // Cria sessão email com e-mail do usuario
			$_SESSION['senha'] = $senha; // Cria sessão com a senha do usuário (sha1)
			$result = ["state" => 'true'];
		} else {
			$result = ["state" => 'false'];
		}
		return json_encode($result);
	}
	
	
	function addAtividade($titulo, $desc, $tipo) {
	 global $conn;
	 global $diaSemana;
	 global $horario;
	 //Condicional: SE for tipo 4 (Manutenção urgente) E sexta-feira E o horario maior que a 13:00 definir state FALSE.
	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
		
		$result = ["state" => 'false'];
	 
	 } else {
		//Query para adicionar a database e definir state true
		$stmt = $conn->prepare("INSERT INTO `atividades` (`id`, `titulo`, `desc`, `tipo`) VALUES (NULL, ?, ?, ?)"); // Prepara consulta
		$stmt->bind_param('ssi', $titulo, $desc, $tipo); // Insere os parametros em '?', respectivamente
		$stmt->execute(); // Executa consulta
		$result = ["state" => 'true'];
	 }
		return json_encode($result);
	}
	
	function listAtividade($tipo) {
		
		//Condicional: SE tipo for 0 listar as de tipo: 1, 2, 3 e 4 (ABERTAS)

		//Tipo 1: Desenvolvimento | Tipo 2: Atendimento | Tipo 3: Manutenção | Tipo 4: Manutenção urgente | Tipo 5: Concluída 
		
		//Querys para adicionar a database e retornar true
		return 'a';
	}
	
	function editAtividade($id, $titulo, $desc, $tipo) {
	 
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