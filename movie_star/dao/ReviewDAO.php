<?php
   require_once("models/Review.php");
   require_once("models/Message.php");
   require_once("dao/UserDAO.php");

   class ReviewDAO implements ReviewDAOInterface {

      private $conn;
      private $url;
      private $message;

      public function __construct(PDO $conn, $url) {
         $this->conn = $conn;
         $this->url = $url;
         $this->message = new Message($url);
      }

      public function buildReview($data) {
         $reviewObject = new Review();

         $reviewObject->id = $data["id"];
         $reviewObject->rating = $data["rating"];
         $reviewObject->review = $data["review"];
         $reviewObject->users_id = $data["users_id"];
         $reviewObject->movies_id = $data["movies_id"];

         return $reviewObject;
      }

      public function create(Review $review) {
         $conn = $this->conn;
         $query = "INSERT INTO reviews (
            rating, review, movies_id, users_id
         ) Values (
            :rating, :review, :movies_id, :users_id
         )";

         $stmt = $conn->prepare($query);
         $stmt->execute([
            "rating" => $review->rating,
            "review" => $review->review,
            "movies_id" => $review->movies_id,
            "users_id" => $review->users_id
         ]);

         // Mensagem de sucesso por adicionar um filme
         $this->message->setMessage("Avaliação adicionada com sucesso!", "success", "back");
      }

      public function getMoviesReview($id) {
         $conn = $this->conn;
         $query = "SELECT * FROM reviews WHERE movies_id = :movies_id";

         $reviews = [];

         $stmt = $conn->prepare($query);
         $stmt->execute(["movies_id" => $id]);

         if($stmt->rowCount() > 0) {
            $reviewsData = $stmt->fetchAll();

            $userDao = new UserDAO($conn, $this->url);

            foreach($reviewsData as $review) {
               $reviewObject = $this->buildReview($review);
               
               // Chamar dados do usuario
               $user = $userDao->findById($reviewObject->users_id);

               $reviewObject->user = $user;

               $reviews[] = $reviewObject;
            }
         }

         return $reviews;
      }

      public function hasAlreadyReviewed($id, $userId) {
         $conn = $this->conn;
         $query = "SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id";

         $stmt = $conn->prepare($query);
         $stmt->execute([
            "movies_id" => $id,
            "users_id" => $userId
         ]);

         if($stmt->rowCount() > 0) {
            return true;
         }

         return false;
      }

      public function getRatings($id) {
         $conn = $this->conn;
         $query = "SELECT * FROM reviews WHERE movies_id = :movies_id";

         $stmt = $conn->prepare($query);
         $stmt->execute(["movies_id" => $id]);

         if($stmt->rowCount() > 0) {
            $rating = 0;
            $reviews = $stmt->fetchAll();

            foreach($reviews as $review) {
               $rating += $review["rating"];
            }

            $rating = round(($rating / count($reviews)), 1);

         } else {
            $rating = "Não avaliado";
         }

         return $rating;
      }

   }

?>