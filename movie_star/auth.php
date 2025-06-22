<?php 
   require_once("templates/header.php");
?>

   <main id="main-container" class="container-fluid">
      <div class="col-md-12">
         <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container">
               <h2>Entrar</h2>
               <form action="<?=$BASE_URL ?>auth_process.php" method="post">
                  <input type="hidden" name="type" value="login">

                  <div class="form-group">
                     <label for="email">E-mail:</label>
                     <input type="email" name="email" class="form-control" id="email" placeholder="Digite o seu e-mail" required>
                  </div>
                  
                  <div class="form-group">
                     <label for="password">Senha:</label>
                     <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha" required>
                  </div>

                  <input type="submit" value="Entrar" class="btn card-btn">
               </form>
            </div>

            <div class="col-md-4" id="register-container">
               <h2>Criar Conta</h2>
               <form action="<?=$BASE_URL ?>auth_process.php" method="post">
                  <input type="hidden" name="type" value="register">

                  <div class="form-group">
                     <label for="email">E-mail:</label>
                     <input type="email" name="email" class="form-control" id="email" placeholder="Digite o seu e-mail" >
                  </div>
                  
                  <div class="form-group">
                     <label for="name">Nome:</label>
                     <input type="text" name="name" class="form-control" id="name" placeholder="Digite seu nome" >
                  </div>

                  <div class="form-group">
                     <label for="lastname">Sobrenome:</label>
                     <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Digite seu sobrenome" >
                  </div>

                  <div class="form-group">
                     <label for="password">Senha:</label>
                     <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha" min="6" >
                  </div>

                  <div class="form-group">
                     <label for="confirmPassword">Confirmar senha:</label>
                     <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirme sua senha" min="6" >
                  </div>

                  <input type="submit" value="Registrar" class="btn card-btn">
               </form>
            </div>
         </div>
      </div>
   </main>

<?php 
   require_once("templates/footer.php");
?>