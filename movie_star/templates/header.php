
<?php 
   require_once("globals.php");
   require_once("config/connection.php");
   require_once("models/Message.php");
   require_once("dao/UserDAO.php");

   $message = new Message($BASE_URL);

   $flashMessage = $message->getMessage();

   if(!empty($flashMessage["msg"])) {
      // Limpar mensagem
      $message->clearMessage();
   }

   $userDao = new UserDAO($conn, $BASE_URL);

   $userData = $userDao->verifyToken();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <link rel="shortcut icon" href="<?=$BASE_URL ?>img/moviestar.ico" type="image/x-icon">

   <!-- BOOTSTRAP -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
   <!-- FONT AWESOME -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <link rel="stylesheet" href="<?=$BASE_URL ?>css/styles.css">
   <link rel="stylesheet" href="<?=$BASE_URL ?>css/medias.css">
   <title>Movie Star</title>
</head>
<body>
   <header>
      <nav id="main-navbar" class="navbar navbar-expand-lg">
         <a href="<?=$BASE_URL ?>index.php" class="navbar-brand">
            <img src="<?=$BASE_URL ?>img/logo.svg" alt="Movie Star" id="logo">
            <span id="moviestar-title">Movie Star</span>
         </a>

         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
         </button>

         <form action="<?=$BASE_URL ?>search.php" method="get" id="search-form" class="form-inline my-2 my-lg-0">
            <input type="search" name="q" id="search" class="form-control mr-sm-2" placeholder="Buscar Filmes" aria-label="Search">
            <button class="btn my-2 my-sm-0" type="submit">
               <i class="fas fa-search"></i>
            </button>
         </form>

         <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">
               <?php if($userData): ?>
                  <li class="nav-item">
                     <a href="<?=$BASE_URL ?>newmovie.php" class="nav-link">
                        <i class="far fa-plus-square"></i> Incluir Filme
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?=$BASE_URL ?>dashboard.php" class="nav-link">Meus Filmes</a>
                  </li>
                  <li class="nav-item">
                     <a href="<?=$BASE_URL ?>editprofile.php" class="nav-link bold"><?=$userData->name ?></a>
                  </li>
                  <li class="nav-item">
                     <a href="<?=$BASE_URL ?>logout.php" class="nav-link">Sair</a>
                  </li>
               <?php else: ?>
                  <li class="nav-item">
                     <a href="<?=$BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                  </li>
               <?php endif; ?>
            </ul>
         </div>
      </nav>
   </header>
   <?php if(!empty($flashMessage["msg"])): ?>
      <div class="msg-container">
         <p class="msg <?=$flashMessage["type"] ?>"><?=$flashMessage["msg"] ?> <i class="fa-solid fa-xmark delete-message" onclick="this.parentElement.remove()"></i></p>
      </div>
   <?php endif; ?>
   