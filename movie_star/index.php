<?php 
   require_once("templates/header.php");
   require_once("dao/MovieDAO.php");

   // DAO dos Filmes
   $movieDao = new MovieDAO($conn, $BASE_URL);

   $latestMovies = $movieDao->getLatestMovies();
   $actionMovies = $movieDao->getMoviesByCategory("Ação");
   $dramaMovies = $movieDao->getMoviesByCategory("Drama");
   $comedyMovies = $movieDao->getMoviesByCategory("Comédia");
   $fictionMovies = $movieDao->getMoviesByCategory("Fantasia / Ficção");
   $romanceMovies = $movieDao->getMoviesByCategory("Romance");
   $horrorMovies = $movieDao->getMoviesByCategory("Terror");
?>

   <main id="main-container" class="container-fluid">
      <h2 class="section-title">Filmes novos</h2>
      <p class="section-description">Veja as críticas dos últimos filmes adicionados no MovieStar</p>
      <div class="movies-container">
         <?php foreach($latestMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($latestMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Ação</h2>
      <p class="section-description">Veja os melhores filmes de ação</p>
      <div class="movies-container">
         <?php foreach($actionMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($actionMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Ação cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Drama</h2>
      <p class="section-description">Veja os melhores filmes de drama</p>
      <div class="movies-container">
         <?php foreach($dramaMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($dramaMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Drama cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Comédia</h2>
      <p class="section-description">Veja os melhores filmes de comédia</p>
      <div class="movies-container">
         <?php foreach($comedyMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($comedyMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Comédia cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Fantásia / Ficção</h2>
      <p class="section-description">Veja os melhores filmes de fantásia / ficção</p>
      <div class="movies-container">
         <?php foreach($fictionMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($fictionMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Fantásia / Ficção cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Romance</h2>
      <p class="section-description">Veja os melhores filmes de romance</p>
      <div class="movies-container">
         <?php foreach($romanceMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($romanceMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Romance cadastrados!</p>
         <?php endif; ?>
      </div>

      <h2 class="section-title">Terror</h2>
      <p class="section-description">Veja os melhores filmes de terror</p>
      <div class="movies-container">
         <?php foreach($horrorMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
         <?php endforeach; ?>
         <?php if(count($horrorMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de Terror cadastrados!</p>
         <?php endif; ?>
      </div>
   </main>

<?php 
   require_once("templates/footer.php");
?>