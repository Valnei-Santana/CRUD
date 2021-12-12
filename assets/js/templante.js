var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 9000
});

var gmodal = new bootstrap.Modal(document.getElementById('modalEdit'), {
  keyboard: false
});
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

$("#addAtividade").click(function() {
	acao.adicionar(); // Adicionar atividade
});

//Função para imprimir a lista de atividades usando jsGrid. Tipo refere-se ao tipo de atividade, ID refere-se ao #id no qual a tabela será imprimida no HTML
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
                    width: "10%"
                },
                {
                    title: "Ação",
                    name: "acao",
                    type: "text",
                    width: "8%",
                    css: "text-center"
                }               



            ]
        });
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
    editar: function(id) {

        $.ajax({
            type: 'POST',
            url: "./../../Project/callBack/main.php?acao=getEdit",
            data: {
                'id': id
            },
            success: function(data) {
                $('#form-edit').html(data.body);
            }
        });

    },
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
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: ' Atividade finalizada com sucesso!'
                        })
                    });

                } else if (data.state == 'false') {
                   $(function() {

                        Toast.fire({
                            icon: 'error',
                            title: ' A atividade deve possuir descrição maior que 50 caracteres!'
                        })
                    });
                }
            }
        });

    },
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
                            title: ' Atividade deletada com sucesso!!'
                        })
                    });

                } else if (data.state == 'false') {
					$(function() {
                        Toast.fire({
                            icon: 'error',
                            title: ' Você não pode deletar atividades do tipo Manutenção Urgente!'
                        })
                    });
				}
            }
        });

    },

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
                            title: 'Este link está sendo usado!!'
                        })
                    });

                } else if (data.state == 'true') {
                   getAtividade(0, 'atvd-list');
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: 'Atividade editada com sucesso!'
                        })
                    });
                   
                }

            }
        });

    },

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
                            title: 'Você não pode adicionar esse tipo de atividade nas sextas-feiras depois das 13:00!'
                        })
                    });

                } else if (data.state == 'true') {
                    getAtividade(0, 'atvd-list');
                    $(function() {

                        Toast.fire({
                            icon: 'success',
                            title: 'Atividade adicionada com sucesso!'
                        })
                    });
                    $('input').val("");
                    $('textarea').val("");
                }


            }
        });

    }
}