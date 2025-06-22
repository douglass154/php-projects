<?php 
   require_once("templates/header.php");
   require_once("models/User.php");
   require_once("dao/UserDAO.php");

   $user = new User();
   $userDao = new UserDAO($conn, $BASE_URL);

   $userData = $userDao->verifyToken(true);

   $fullName = $user->getFullName($userData);

?>

<main id="main-container" class="container-fluid edit-profile-page">
   <div class="col-md-12">
      <form action="<?=$BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="type" value="update">

         <div class="row">
            <div class="col-md-4">
               <h1><?=$fullName ?></h1>
               <p class="page-description">Altere seus dados no formulário abaixo:</p>
               <div class="form-group">
                  <label for="name">Nome:</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Digite o seu nome"
                     value="<?=$userData->name ?>">
               </div>
               <div class="form-group">
                  <label for="lastname">Sobrenome:</label>
                  <input type="text" name="lastname" class="form-control" id="lastname"
                     placeholder="Digite o seu sobrenome" value="<?=$userData->lastname ?>">
               </div>
               <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" readonly name="email" class="form-control disabled" id="email"
                     value="<?=$userData->email ?>">
               </div>
               <input type="submit" class="btn card-btn" value="Atualizar">
            </div>
            <div class="col-md-4">
               <div id="profile-img-container"
                  style="background-image: url('<?=$BASE_URL ?>img/users/<?=$userData->image ?: "user.png" ?>');"></div>
               <div class="form-group">
                  <label for="image">Foto:</label>
                  <input type="file" name="image" class="form-control-file" id="image">
               </div>
               <div class="form-group">
                  <label for="bio">Sobre mim:</label>
                  <textarea name="bio" class="form-control" id="bio" rows="5"
                     placeholder="Conte mais sobre você"><?=$userData->bio ?></textarea>
               </div>
            </div>
         </div>
      </form>
      <div class="row" id="change-password-container">
         <div class="col-md-4">
            <h2>Alterar senha</h2>
            <p class="page-description">Digite a nova senha e confirme para alterá-la:</p>
            <form action="<?=$BASE_URL ?>user_process.php" method="post">
               <input type="hidden" name="type" value="changePassword">
               <div class="form-group">
                  <label for="password">Nova senha:</label>
                  <input type="password" name="password" class="form-control" id="password"
                     placeholder="Digite sua nova senha">
               </div>
               <div class="form-group">
                  <label for="confirmPassword">Confirmar senha:</label>
                  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                     placeholder="Confirme sua senha">
               </div>
               <input type="submit" value="Alterar senha" class="btn card-btn">
            </form>
         </div>
      </div>
   </div>
</main>

<?php 
   require_once("templates/footer.php");
?>