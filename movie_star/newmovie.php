<?php 
   require_once("templates/header.php");

   // Verifica se o usuário está autenticado
   require_once("models/User.php");
   require_once("dao/UserDAO.php");

   $user = new User();
   $userDao = new UserDAO($conn, $BASE_URL);

   $userData = $userDao->verifyToken(true);
?>

<main id="main-container" class="container-fluid">
   <div class="offset-md-4 col-md-4 new-movie-container">
      <h1 class="page-title">Adicionar Filme</h1>
      <p class="page-description">Adicione sua crítica e compartilhe com o mundo</p>
      <form action="<?=$BASE_URL ?>movie_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="type" value="create">
         <div class="form-group">
            <label for="title">Título:</label>
            <input class="form-control" id="title" type="text" name="title" placeholder="Digite o título do filme">
         </div>
         <div class="form-group">
            <label for="image">Imagem:</label>
            <input class="form-control" id="image" type="file" name="image">
         </div>
         <div class="form-group">
            <label for="length">Duração:</label>
            <input class="form-control" id="length" type="text" name="length" placeholder="Digite a duração do filme">
         </div>
         <div class="form-group">
            <label for="category">Categoria:</label>
            <select name="category" id="category" class="form-control">
               <option value="">Selecione</option>
               <option value="Ação">Ação</option>
               <option value="Drama">Drama</option>
               <option value="Comédia">Comédia</option>
               <option value="Fantasia / Ficção">Fantasia / Ficção</option>
               <option value="Romance">Romance</option>
               <option value="Terror">Terror</option>
            </select>
         </div>
         <div class="form-group">
            <label for="trailer">Trailer:</label>
            <input class="form-control" id="trailer" type="text" name="trailer" placeholder="Insira o link do trailer">
         </div>
         <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Descrição do filme"></textarea>
         </div>
         <input type="submit" value="Adicionar Filme" class="btn card-btn">
      </form>
   </div>
</main>

<?php 
   require_once("templates/footer.php");
?>