// Inicia o framework de Toast's (que exibe mensagens de erro/success)
var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 9000
});

// Ao iniciar a página carregar a lista de atividades abertas
$(document).ready(function() {
    getAtividade(0, 'atvd-list'); // Tipo 0 retorna a lista de atividades abertas
});

// Sempre que clicar em #list-home-list (Gerenciar Atividades) carregar uma nova lista
$("#list-home-list").click(function() {
	getAtividade(5, 'fechadas-list'); // Qualquer tipo diferente de 0 retorna atividades fechadas
});

// Sempre que clicar em #list-ativ-list (Atividades concluídas) carregar uma nova lista
$("#list-ativ-list").click(function() {
	getAtividade(5, 'fechadas-list'); // Qualquer tipo diferente de 0 retorna atividades fechadas
});

// Ao clicar em Adicionar (dentro do Modal)
$("#addAtividade").click(function() {
	acao.adicionar(); // Adicionar atividade
});

//Função para imprimir a lista de atividades usando jsGrid. Tipo refere-se ao tipo de atividade (Igual a 0 = Abertas | Diferente de 0 = Concluídas), ID refere-se ao #id no qual a tabela será imprimida no HTML
function getAtividade(tipo, id) {
$.ajax({
    type: "POST",
    dataType: "json",
    url: "./../../Project/callBack/main.php?acao=listAtvd",
    data: {
        'tipo': tipo
    },
    success: function(data) {
        $('#' + id).html('');
        var json = data;
        $("#" + id).jsGrid({
            noDataContent: "Nenhuma atividade encontrada!",
            height: "auto",
            width: "100%",
            pageSize: 20,
            pageButtonCount: 3,
            tableClass: "table table-striped projects",


            pagerFormat: "Páginas: {pages} &nbsp;&nbsp;",
            editing: false,
            noDataContent: "Não encontrado",

            sorting: true,
            paging: true,

            data: json,


            fields: [


                {
                    title: "ID",
                    name: "id",
                    type: "number",
                    width: "6%"
                },
                {
                    title: "Titulo",
                    name: "titulo",
                    width: "20%"
                },
				{
                    title: "Descrição",
                    name: "desc",
                    type: "text",
                    width: "40%"
                },
				{
                    title: "Tipo",
                    name: "tipo",
                    type: "text",
                    width: "20%"
                },
                {
                    title: "Ação",
                    name: "acao",
                    type: "text",
                    width: "10%",
                    css: "text-center"
                }               



            ]
        });
		// Efeito de mudança na tabela (visual)
        $('#' + id ).animate({
            opacity: 0.5
        }, 500);
        $('#' + id).animate({
            opacity: 1
        });
    }
});
}

// Ações que serão realizadas
acao = {
	//Metodo que retorna as informações da atividade que será editada no MODAL, (Titulo, Tipo e Descrição)
    editar: function(id) {

        $.ajax({
            type: 'POST',
            url: "./../../Project/callBack/main.php?acao=getEdit",
            data: {
                'id': id
            },
            success: function(data) {
                $('#titulo-edit').val(data.titulo);
			 $('#desc-edit').val(data.desc);
			$('#default-tipo').val(data.tipo);
			$('#default-tipo').html(data.tipoName);
			$('#editButton').attr('onClick', 'acao.salvar('+ id +');');
            }
        });

    },
	//Metodo que conclui uma atividade, recebe ID como parametro.
    fim: function(id) {

        $.ajax({
            type: 'POST',
             url: "./../../Project/callBack/main.php?acao=fimAtvd",
            data: {
                'id': id
            },
            success: function(data) {
                if (data.state == 'true') {
					getAtividade(0, 'atvd-list');
					getAtividade(5, 'fechadas-list');
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    });

                } else if (data.state == 'false') {
                   $(function() {

                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    });
                }
            }
        });

    },
	//Metodo que deleta uma atividade, recebe ID como parametro.
    deletar: function(id) {

        $.ajax({
            type: 'POST',
            url: "./../../Project/callBack/main.php?acao=deleteAtvd",
            data: {
                'id': id
            },
            success: function(data) {
                if (data.state == 'true') {
                    getAtividade(0, 'atvd-list');
                    $(function() {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    });

                } else if (data.state == 'false') {
					$(function() {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    });
				}
            }
        });

    },
    //Metodo que salva as alterações de uma atividade editada, (é chamada no botão 'Salvar' dentro do MODAL EDITAR)
    salvar: function(id) {
       var titulo = $('#titulo-edit').val();
        var desc = $('#desc-edit').val();
        var tipo = $('#tipo-edit').val();

        $.ajax({
            type: 'POST',
            url: "./../../Project/callBack/main.php?acao=editAtvd",
            data: {
				'id': id,
                'titulo': titulo,
                'desc': desc,
                'tipo': tipo
            },

            success: function(data) {
                if (data.state == 'false') {
                    $(function() {

                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    });

                } else if (data.state == 'true') {
                   getAtividade(0, 'atvd-list');
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    });
                   
                }

            }
        });

    },
	//Metodo que cria uma atividade, (é chamada no botão 'Salvar' dentro do MODAL ADICIONAR)
    adicionar: function() {
        var titulo = $('#titulo-add').val();
        var desc = $('#desc-add').val();
        var tipo = $('#tipo-add').val();
   
        $.ajax({
            type: 'POST',
            url: "./../../Project/callBack/main.php?acao=addAtvd",
            data: {
                'titulo': titulo,
                'desc': desc,
                'tipo': tipo
            },
            success: function(data) {
                if (data.state == 'false') {
                    $(function() {

                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    });

                } else if (data.state == 'true') {
                    getAtividade(0, 'atvd-list');
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    });
                    $('input').val("");
                    $('textarea').val("");
                }


            }
        });

    }
}