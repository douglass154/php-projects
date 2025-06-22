<?php
   require_once("models/Movie.php");
   require_once("models/Message.php");

   // Review DAO
   require_once("dao/ReviewDAO.php");

   class MovieDAO implements MovieDaoInterface {
      private $conn;
      private $url;
      private $message;

      public function __construct(PDO $conn, $url) {
         $this->conn = $conn;
         $this->url = $url;
         $this->message = new Message($url);
      }

      public function buildMovie($data) {
         $movie = new Movie();

         $movie->id = $data["id"];
         $movie->title = $data["title"];
         $movie->description = $data["description"];
         $movie->image = $data["image"];
         $movie->trailer = $data["trailer"];
         $movie->category = $data["category"];
         $movie->length = $data["length"];
         $movie->users_id = $data["users_id"];
         
         // Recebe as ratings do filme
         $reviewDao = new ReviewDAO($this->conn, $this->url);

         $rating = $reviewDao->getRatings($movie->id);
         $movie->rating = $rating;

         return $movie;
      }

      public function findAll() {

      }

      public function getLatestMovies() {

         $movies = [];

         $conn = $this->conn;
         $query = "SELECT * FROM movies ORDER BY id DESC";

         $stmt = $conn->query($query);
         $stmt->execute();

         if($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($moviesArray as $movie) {
               $movies[] = $this->buildMovie($movie);
            }
         }

         return $movies;
      }

      public function getMoviesByCategory($category) {
         $movies = [];

         $conn = $this->conn;
         $query = "SELECT * FROM movies
            WHERE category = :category
            ORDER BY id DESC
         ";

         $stmt = $conn->prepare($query);
         $stmt->execute(["category" => $category]);

         if($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($moviesArray as $movie) {
               $movies[] = $this->buildMovie($movie);
            }
         }

         return $movies;
      }

      public function getMoviesByUserId($id) {
         $movies = [];

         $conn = $this->conn;
         $query = "SELECT * FROM movies WHERE users_id = :users_id";

         $stmt = $conn->prepare($query);
         $stmt->execute(["users_id" => $id]);

         if($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie) {
               $movies[] = $this->buildMovie($movie);
            }
         }

         return $movies;
      }
      
      public function findById($id) {
         $movie = [];

         $conn = $this->conn;
         $query = "SELECT * FROM movies WHERE id = :id";

         $stmt = $conn->prepare($query);
         $stmt->execute(["id" => $id]);

         if($stmt->rowCount() > 0) {
            $movieData = $stmt->fetch();

            $movie = $this->buildMovie($movieData);
            return $movie;
         } else {
            return false;
         }
      }

      public function findByTitle($title) {
         $movies = [];

         $conn = $this->conn;
         $query = "SELECT * FROM movies WHERE title LIKE :title";

         $stmt = $conn->prepare($query);
         $stmt->execute(["title" => "%".$title."%"]);

         if($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie) {
               $movies[] = $this->buildMovie($movie);
            }
         }

         return $movies;
      }

      public function create(Movie $movie) {
         $conn = $this->conn;
         $query = "INSERT INTO movies (
            title, description, image, trailer, category, length, users_id 
         ) Values (
            :title, :description, :image, :trailer, :category, :length, :users_id
         )";

         $stmt = $conn->prepare($query);
         $stmt->execute([
            "title" => $movie->title,
            "description" => $movie->description,
            "image" => $movie->image,
            "trailer" => $movie->trailer,
            "category" => $movie->category,
            "length" => $movie->length,
            "users_id" => $movie->users_id
         ]);

         // Mensagem de sucesso por adicionar um filme
         $this->message->setMessage("Filme adicionado com sucesso!", "success", "index.php");
      }

      public function update(Movie $movie) {
         $conn = $this->conn;
         $query = "UPDATE movies SET
            title = :title,
            description = :description,
            image = :image,
            trailer = :trailer,
            category = :category,
            length = :length
            WHERE id = :id   
         ";

         $stmt = $conn->prepare($query);
         $stmt->execute([
            "title" => $movie->title,
            "description" => $movie->description,
            "image" => $movie->image,
            "trailer" => $movie->trailer,
            "category" => $movie->category,
            "length" => $movie->length,
            "id" => $movie->id
         ]);

         // Mensagem de sucesso por remover um filme
         $this->message->setMessage("Filme atualizado com sucesso!", "success", "dashboard.php");
      }

      public function destroy($id) {
         $conn = $this->conn;
         $query = "DELETE FROM movies WHERE id = :id";
         
         $stmt = $conn->prepare($query);
         $stmt->execute(["id" => $id]);

         // Mensagem de sucesso por remover um filme
         $this->message->setMessage("Filme removido com sucesso!", "success", "dashboard.php");
      }

   }