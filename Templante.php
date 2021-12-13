<?php
session_start(); //Inicia sessão
if(!isset($_SESSION['email'])) { // Se SESSION['email'] não for definida exibir mensagem
	echo 'Você não possui acesso a essa página'; 
	exit();
}
$pageid = 2; // Define o numero da pagina
$pagename = 'Gerenciamento de atividades'; // Define o nome da página (titulo)
include 'Includes/header.php'; //Include header, cabeçalho HTML
?>
   <body>
   <div class="container-fluid ct-layout">
 <h4>Bem-vindo ao sistema! Logado como: <?php echo $_SESSION['email'];?></h4>
 <div class="row">
  <div class="col-4">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Gerenciar Atividades</a>
	  <a class="list-group-item list-group-item-action" id="list-ativ-list" data-bs-toggle="list" href="#list-ativ" role="tab" aria-controls="list-ativ">Atividades concluídas</a>
    </div>
  </div>
  <div class="col-8 pl-0">
    <div class="tab-content " id="nav-tabContent">
	<div id="list-home" role="tabpanel" aria-labelledby="list-home-list" class="card tab-pane fade show active">
	
  <div class="card-body">
    <h5 class="card-title">Atividades abertas <button style="float:right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdd">Adicionar atividade</button></h5>
    <h6 class="card-subtitle mb-2 text-muted">Informações referente as atividades;</h6>

  <div id="atvd-list"></div>
  </div>
</div>
	<div id="list-ativ" role="tabpanel" aria-labelledby="list-home-list" class="card tab-pane fade show">
	
  <div class="card-body">
    <h5 class="card-title">Atividades concluidas</h5>
    <h6 class="card-subtitle mb-2 text-muted">Informações referente as atividades;</h6>
 
  <div id="fechadas-list"></div>
  </div>
</div>
    </div>
  </div>
</div>
<!-- Modal Adicionar Atividade -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar atividade</h5>
      </div>
      <div class="modal-body">
	    <div class="form-group">
		<label for="titulo-add">Título</label>
 <input id="titulo-add" class="form-control" type="text" placeholder="Titulo">
  </div>
   <div class="form-group">
		<label for="titulo-add">Tipo</label>
 <select id="tipo-add" class="form-control">
  <option value="1">Desenvolvimento</option>
  <option value="2">Atendimento</option>
  <option value="3">Manutenção</option>
  <option value="4">Manutenção urgente</option>
</select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Descrição</label>
    <textarea id="desc-add" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="addAtividade" type="button" class="btn btn-primary" data-dismiss="modal">Adicionar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Atividade -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar atividade</h5>
      </div>
      <div id="form-edit" class="modal-body">
	<div class="form-group">
		<label for="titulo-add">Título</label>
 <input id="titulo-edit" class="form-control" value="" type="text" placeholder="Titulo">
  </div>
   <div class="form-group">
		<label for="titulo-add">Tipo</label>
 <select id="tipo-edit" class="form-control">
 <option value="" id="default-tipo"></option>
  <option value="1">Desenvolvimento</option>
  <option value="2">Atendimento</option>
  <option value="3">Manutenção</option>
  <option value="4">Manutenção urgente</option>
</select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Descrição</label>
    <textarea id="desc-edit" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="editButton" type="button" class="btn btn-primary" data-dismiss="modal">Salvar</button>
      </div>
     
    </div>
  </div>
</div>
</div>
<?php include 'Includes/footer.php'; //Include FOOTER da página ?>