<?php
   // Inclusão da conexão MySQL
   require_once('conexao.php');
   //Set linguagem PT (dias da semanas, meses são exibidos em português)
   setlocale(LC_TIME, 'pt');
   
   // Set timezone SP (horario SP)
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
   		if($row_cnt > 0) { // Se possuir registro continua e retorna TRUE e mensagem de sucesso, caso contrario FALSE e mensagem de erro
   			session_start(); // Inicia uma sessão
   			$_SESSION['email'] = $email; // Cria sessão email com e-mail do usuario
   			$_SESSION['senha'] = $senha; // Cria sessão com a senha do usuário (sha1)
   			$result = ["state" => 'true', "message" => '<strong>Sucesso!</strong> Você será redirecionado em alguns instantes...'];
   		} else {
   			$result = ["state" => 'false', "message" => '<strong>Erro!</strong> E-mail ou senha não conferem'];
   		}
   		return json_encode($result);
   	}
   	
   	
   	function addAtividade($titulo, $desc, $tipo) {
   	 global $conn;
   	 global $diaSemana;
   	 global $horario;
   	 //Condicional: SE for tipo 4 (Manutenção urgente) E sexta-feira E o horario maior que a 13:00 definir state FALSE e mensagem de erro.
   	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
   		
   		$result = ["state" => 'false', "message" => 'Você não pode adicionar esse tipo de atividade nas sextas-feiras depois das 13:00!'];
   	 
   	 } else {
   		//Query para adicionar a database e definir state true
   		$stmt = $conn->prepare("INSERT INTO `atividade` (`id`, `titulo`, `desc`, `tipo`) VALUES (NULL, ?, ?, ?)"); // Prepara consulta
   		$stmt->bind_param('ssi', $titulo, $desc, $tipo); // Insere os parametros em '?', respectivamente
   		$stmt->execute(); // Executa consulta
   		$result = ["state" => 'true', "message" => 'Atividade adicionada com sucesso!'];
   	 }
   		return json_encode($result);
   	}
   	
   	function listAtividade($tipo) {
   		global $conn;
   		//Condicional: SE tipo for 0 as com concluida = 0 (abertas), caso contrario listar COM concluida = 1 (FECHADAS)
   		//Tipo 1: Desenvolvimento | Tipo 2: Atendimento | Tipo 3: Manutenção | Tipo 4: Manutenção urgente
   		if($tipo == 0){
   		$stmt = $conn->prepare("SELECT * FROM atividade WHERE concluida = '0'"); // Prepara consulta
   		$stmt->execute();
   		} else {
   		$stmt = $conn->prepare("SELECT * FROM atividade WHERE concluida = '1'"); // Prepara consulta
   		$stmt->execute();
   		}
   		$result = $stmt->get_result(); //Busco os resultados da consulta
   		$lista = []; //Defino lista como array
   		
   		while ($row = $result->fetch_assoc()) //Repetidor para incluir as linhas encontradas dentro de '$lista'
           {
   			$tipo = '';
   			$idEdit = '"'.$row['id'].'"';
   			if($row['tipo'] == 1) { $tipo = 'Desenvolvimento';} else
   			if($row['tipo'] == 2) { $tipo = 'Atendimento';} else
   			if($row['tipo'] == 3) { $tipo = 'Manutenção';} else
   			if($row['tipo'] == 4) { $tipo = 'Manutenção urgente';} else
   			{ $tipo = 'Concluída';}
   			if($row['concluida'] == 0) { 
   			$botoes = '<div class="btn-group btn-group-sm"><a onclick="acao.fim('.$row['id'].');" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Fechar"><i class="fa fa-check"></i></a><a data-toggle="modal" data-target="#modalEdit" onclick="acao.editar('.$row['id'].');" class="btn btn-info"><i class="fa fa-edit"></i></a><a onclick="acao.deletar('.$row['id'].');" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>';
   			} else {
   			$botoes = '<div class="btn-group btn-group-sm"><a onclick="acao.fim('.$row['id'].');" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Abrir"><i class="fa fa-times"></i></a></div>'; }
   			$lista[] = ["id" => $row['id'], "titulo" => $row['titulo'], "desc" => substr($row['desc'], 0, 20).'...', "tipo" => $tipo, "acao" => $botoes];
   		}
   
   		return json_encode($lista);
   	}
   	
   	function editAtividade($id, $titulo, $desc, $tipo) {
   	 global $conn;
   	 global $diaSemana;
   	 global $horario;
   	 //Condicional: SE for tipo 4 E sexta-feira E o horario (atual) maior que a 13:00 definir state FALSE, caso contrário atualize atividade
   	 if($tipo == 4 && $diaSemana == 'sexta-feira' && $horario > 1300) {
   		
   		$result = ["state" => 'false', "message" => 'Você não pode definir uma Manutenção urgente depois das 13:00 nas sextas!'];
   	 
   	 } else {
   		//Query para editar a atividade do ID solicitado.
   		$stmt = $conn->prepare("UPDATE atividade SET `titulo` = ?, `desc` = ?, `tipo` = ? WHERE `id` = ?"); // Prepara consulta
   		$stmt->bind_param('ssii', $titulo, $desc, $tipo, $id); // Insere os parametros em '?', respectivamente
   		$stmt->execute();
   		$result = ["state" => 'true', "message" => 'Atividade editada com sucesso!'];
   		
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
   		
   		if($row['tipo'] == 1) { $tipo = 'Desenvolvimento';} else
   		if($row['tipo'] == 2) { $tipo = 'Atendimento';} else
   		if($row['tipo'] == 3) { $tipo = 'Manutenção';} else
   		if($row['tipo'] == 4) { $tipo = 'Manutenção urgente';}
   	
   	$atividade = ["state" => 'true', "titulo" => $row['titulo'], "tipoName" => $tipo, "tipo" => $row['tipo'], "desc" => $row['desc']];
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
   		
   		$result = ["state" => 'false', "message" => 'Atividades de manutenção urgente não podem ser removidas, apenas finalizadas'];
   	 
   		} else {
   		$stmt = $conn->prepare("DELETE FROM atividade WHERE id = ?"); // Prepara consulta
   		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
   		$stmt->execute();
   		$result = ["state" => 'true', "message" => 'Atividade deletada com sucesso!'];
   		
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
   		$tipo = $row['tipo'];
   		$concluida = $row['concluida'];
   		//Condicional: SE Tipo for atendimento (2) ou manutenção urgentes (4) E descrição for menor que 50 caracteres retornar FALSE
   		if(($tipo == 2 || $tipo == 4) && strlen($desc) < 50) {
   		
   		$result = ["state" => 'false', "message" => 'Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres'];
   	 
   		} else if($concluida == 0) {
   		// Finaliza atividade atualizando ela pra concluida = 1 (FECHADA)
   		$stmt = $conn->prepare("UPDATE atividade SET concluida = '1' WHERE id = ?"); // Prepara consulta
   		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
   		$stmt->execute();
   		$result = ["state" => 'true', "message" => 'Atividade concluída com sucesso!'];
   		
   		} else if($concluida == 1) {
   		// Reabre atividade atualizando ela pra concluida = 0 (ABERTA)
   		$stmt = $conn->prepare("UPDATE atividade SET concluida = '0' WHERE id = ?"); // Prepara consulta
   		$stmt->bind_param('i', $id); // Insere os parametros em '?', respectivamente
   		$stmt->execute();
   		$result = ["state" => 'true', "message" => 'Atividade aberta com sucesso!'];
   		
   		}
   		
   		return json_encode($result);
   		//Query para finalizar uma atividade, ao finalizar retornar TRUE
   		
   	}
   }
   
   ?>