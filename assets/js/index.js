 //Função login, envia informações digitas no campo e-mail e senha para o main callBack, onde faz as comparações e retorna true ou false e a mensagem de erro.
 function login() {
		   var email = $('#id_email').val();
		   var senha = $('#id_senha').val();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "./../../Project/callBack/main.php?acao=login", //Project refere-se a pasta no qual o projeto foi criado, URL deve ser configurada corretamente.
        data: {
            'email': email,
			'senha': senha
        },
        success: function(data) {
            if (data.state == 'true') {
				if($("#alerta").hasClass("alert-danger"))
				$("#alerta").removeClass("alert-danger");
				
               $("#alerta").addClass("alert-success show");
			   $("#messageErro").html(data.message);
			   
			   location.href = 'templante.php'; // Redireciona para a página de usuários logados (protegida por SESSION)

            } else if (data.state == 'false') {
				if($("#alerta").hasClass("alert-success"))
				$("#alerta").removeClass("alert-success");
				
				$("#alerta").addClass("alert-danger show");
			   $("#messageErro").html(data.message);
            } else {
                $(function() {
				console.log('error');
				
                });
            }
        }
    });
}  
  //Função exibir/ocultar senha (input password)
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');
 
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});

