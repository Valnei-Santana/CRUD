<?php
$pageid = 1; // Define o numero da pagina
$pagename = 'Entrar'; // Define o nome da página (titulo)
include 'Includes/header.php'; //Include header, cabeçalho HTML
?>
   <body>
      <div class="container page-container">
	  
         <div class="row align-items-center">
            <div class="col">
               <div class="wrapper in-left">
                  <div id="formContent">
                     <!-- Logo
                     <div class="logo-box">
                        <div class="logo"></div>
                     </div> -->
                     <!-- Login Form -->
                    
<div id="alerta" class="alert alert-dismissible fade" role="alert">

  <span id="messageErro"></span>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
                        <label for="email" class="form-label"><b>E-mail</b></label>
						
                        <input type="email" id="id_email" class="fadeIn second" name="login" placeholder="Insira seu e-mail">
                        <!--<div class="erro">E-mail digitado não confere.</div>-->
                        <label for="password" class="form-label"><b>Senha</b></label>
                        <i class="fa fa-user icon icon-input"></i>
						
                        <input id="id_password" type="password" id="password" class="fadeIn third" name="login" placeholder="Insira sua senha">
                        <i class="fa fa-lock icon icon-input"></i>
                        <i id="togglePassword" class="fa fa-eye icon icon-eye"></i>
						<input type="submit" onclick="login();" class="fadeIn fourth" value="entrar">
                
						<!-- Remind Passowrd -->
                        <div id="formFooter">
                           <a class="underlineHover" href="#">Esqueceu sua senha?</a>
                        </div>
						
                     
					
                  </div>
               </div>
            </div>
            <div class="col align-items-center">
               <div class="image animated fadeInRight"></div>
            </div>
         </div>
      </div>
<?php include 'Includes/footer.php'; //Include FOOTER da página?>