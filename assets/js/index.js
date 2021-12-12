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
			   $("#messageErro").html("<strong>Sucesso!</strong> Você será redirecionado em alguns instantes...");
			   
			   location.href = 'templante.php';

            } else if (data.state == 'false') {
				if($("#alerta").hasClass("alert-success"))
				$("#alerta").removeClass("alert-success");
				
				$("#alerta").addClass("alert-danger show");
			   $("#messageErro").html("<strong>Erro!</strong> E-mail ou senha não conferem");
            } else {
                $(function() {
				console.log('error');
				
                });
            }
        }
    });
}  
  //Function hide/show password input
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');
 
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});

