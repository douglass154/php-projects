<?php 
   require_once("templates/header.php");
   require_once("dao/MovieDAO.php");

   // DAO dos Filmes
   $movieDao = new MovieDAO($conn, $BASE_URL);

   // Resgata busca do usuário
   $query = filter_input(INPUT_GET, "q");

   $movies = $movieDao->findByTitle($query);

?>

   <main id="main-container" class="container-fluid">
      <h2 class="section-title" id="search-title">Você está buscando por: <span id="search-result"><?=$query ?></span></h2>
      <p class="section-description">Resultados de busca retornados com base na sua pesquisa.</p>
      <div class="movies-container">
         <?php foreach($movies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($movies) === 0): ?>
            <p class="empty-list">Não há filmes para esta busca, <a href="<?=$BASE_URL ?>index.php" class="back-link">Voltar</a></p>
         <?php endif; ?>
      </div>
   </main>

<?php 
   require_once("templates/footer.php");
?>