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
		$stmt = $conn->prepare("INSERT INTO `atividade` (`id`, `titulo`, `desc`, `tipo`) VALUES (NULL, ?, ?, ?)"); // Prepara consulta
		$stmt->bind_param('ssi', $titulo, $desc, $tipo); // Insere os parametros em '?', respectivamente
		$stmt->execute(); // Executa consulta
		$result = ["state" => 'true'];
	 }
		return json_encode($result);
	}
	
	function listAtividade($tipo) {
		global $conn;
		//Condicional: SE tipo for 0 listar as de tipo: 1, 2, 3 e 4 (ABERTAS), caso contrario listar a de tipo 5 (FECHADAS)
		//Tipo 1: Desenvolvimento | Tipo 2: Atendimento | Tipo 3: Manutenção | Tipo 4: Manutenção urgente | Tipo 5: Concluída 
		if($tipo == 0){
		$stmt = $conn->prepare("SELECT * FROM atividade WHERE tipo > 0 AND tipo < 5"); // Prepara consulta
		$stmt->execute();
		} else {
		$stmt = $conn->prepare("SELECT * FROM atividade WHERE tipo = 5"); // Prepara consulta
		$stmt->execute();
		}
		$result = $stmt->get_result(); //Busco os resultados da consulta
		$lista = []; //Defino lista como array
		
		while ($row = $result->fetch_assoc()) //Repetidor para incluir as linhas encontradas dentro de '$lista'
        {
			$tipo = '';
			$idEdit = '"'.$row['id'].'"';
			if($row['tipo'] == 1) { $tipo = 'Desenvolvimento';}
			if($row['tipo'] == 2) { $tipo = 'Atendimento';}
			if($row['tipo'] == 3) { $tipo = 'Manutenção';}
			if($row['tipo'] == 4) { $tipo = 'Manutenção urgente';}
			if($row['tipo'] == 5) { $tipo = 'Concluída';}
			$lista[] = ["id" => $row['id'], "titulo" => $row['titulo'], "desc" => $row['desc'], "tipo" => $tipo, "acao" => '<div class="btn-group btn-group-sm"><a onclick="acao.fim('.$row['id'].');" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Aprovar"><i class="fa fa-check"></i></a><a data-toggle="modal" data-target="#modalEdit" onclick="acao.editar('.$row['id'].');" class="btn btn-info"><i class="fa fa-edit"></i></a><a onclick="acao.deletar('.$row['id'].');" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>'];
		}

		return json_encode($lista);
	}
	
	function editAtividade($id, $titulo, $desc, $tipo) {
	 global $conn;
	 global $diaSemana;
	 global $horario;
	 //Condicional: SE for tipo 4 E sexta-feira E o horario (atual) maior que a 13:00 definir state FALSE, caso contrário atualize atividade
	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
		
		$result = ["state" => 'false'];
	 
	 } else {
		//Query para editar a atividade do ID solicitado.
		$stmt = $conn->prepare("UPDATE atividade SET `titulo` = ?, `desc` = ?, `tipo` = ? WHERE `id` = ?"); // Prepara consulta
		$stmt->bind_param('ssii', $titulo, $desc, $tipo, $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = ["state" => 'true'];
		
	 }
		return json_encode($result);
		
	}
	
	function getAtividade($id) {
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM atividade WHERE id = ? LIMIT 1"); // Prepara consulta
		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		
		$formBody = '    <div class="form-group">
		<label for="titulo-add">Título</label>
 <input id="titulo-edit" class="form-control" value="'.$row['titulo'].'" type="text" placeholder="Titulo">
  </div>
   <div class="form-group">
		<label for="titulo-add">Tipo</label>
 <select id="tipo-edit" class="form-control">
  <option value="1">Desenvolvimento</option>
  <option value="2">Atendimento</option>
  <option value="3">Manutenção</option>
  <option value="4">Manutenção urgente</option>
</select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Descrição</label>
    <textarea id="desc-edit" class="form-control" id="exampleFormControlTextarea1" rows="3">'.$row['desc'].'</textarea>
  </div>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button onclick="acao.salvar('.$row['id'].')" type="button" class="btn btn-primary" data-dismiss="modal">Salvar</button>
      </div>
  ';
  $atividade = ["state" => 'true', "body" => $formBody];
  return json_encode($atividade);
	}
	
	function removeAtividade($id) {
		//Query para puxar informações do ID solicitado $tipo é definido através dessa consulta
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM atividade WHERE id = ? LIMIT 1"); // Prepara consulta
		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$tipo = $row['tipo'];
		//Condicional: SE atividade for tipo 4 definir stete FALSE.
		if($tipo == 4) {
		
		$result = ["state" => 'false'];
	 
		} else {
		$stmt = $conn->prepare("DELETE FROM atividade WHERE id = ?"); // Prepara consulta
		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = ["state" => 'true'];
		
		}
		
		return json_encode($result);
		
	}
	
	function fimAtividade($id) {
		//Query para puxar informações do ID solicitado $desc é definido através dessa consulta
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM atividade WHERE id = ? LIMIT 1"); // Prepara consulta
		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$desc = $row['desc'];
		//Condicional: SE descrição for menor que 50 caracteres retornar FALSE
		if(strlen($desc) < 50) {
		
		$result = ["state" => 'false'];
	 
		} else {
		// Finaliza atividade atualizando ela pro ID 5
		$stmt = $conn->prepare("UPDATE atividade SET tipo = 5 WHERE id = ?"); // Prepara consulta
		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
		$stmt->execute();
		$result = ["state" => 'true'];
		
		}
		
		return json_encode($result);
		//Query para finalizar uma atividade, ao finalizar retornar TRUE
		
	}
}

?>