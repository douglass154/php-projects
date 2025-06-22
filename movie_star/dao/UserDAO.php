<?php
   require_once("models/User.php");
   require_once("models/Message.php");

   class UserDAO implements UserDAOInterface {

      private $conn;
      private $url;
      private $message;

      public function __construct(PDO $conn, $url) {
         $this->conn = $conn;
         $this->url = $url;
         $this->message = new Message($url);
      }

      public function build($data) {
         $user = new User();

         $user->id = $data["id"];
         $user->name = $data["name"];
         $user->lastname = $data["lastname"];
         $user->email = $data["email"];
         $user->password = $data["password"];
         $user->image = $data["image"];
         $user->bio = $data["bio"];
         $user->token = $data["token"];

         return $user;
      }

      public function create(User $user, $authUser = false) {
         $conn = $this->conn;

         $stmt = $conn->prepare("INSERT INTO users (
            name, lastname, email, password, token
         ) VALUES (
            :name, :lastname, :email, :password, :token 
         )");

         $stmt->execute([
            "name" => $user->name,
            "lastname" => $user->lastname,
            "email" => $user->email,
            "password" => $user->password,
            "token" => $user->token,
         ]);

         // Autenticar usuário caso auth seja true;
         if($authUser) {
            $this->setTokenToSession($user->token);
         }

      }
      
      public function update(User $user, $redirect = true) {
         $conn = $this->conn;
         $query = "UPDATE users SET
            name = :name,
            lastname = :lastname,
            email = :email,
            image = :image,
            bio = :bio,
            token = :token
            WHERE id = :id
         ";

         $stmt = $conn->prepare($query);

         $stmt->execute([
            "name" => $user->name,
            "lastname" => $user->lastname,
            "email" => $user->email,
            "image" => $user->image,
            "bio" => $user->bio,
            "token" => $user->token,
            "id" => $user->id
         ]);

         if($redirect) {
            $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
         }

      }

      public function verifyToken($protected = false) {
         if(!empty($_SESSION["token"])) {
            // Pega o token da session
            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if($user) {
               return $user;
            } else if($protected) {
               // Redireciona usuário não autenticado
               $this->message->setMessage("Faça a autenticação para acessar esta página!", "error");
            }

         } else if($protected) {
            $this->message->setMessage("Faça a autenticação para acessar esta página!", "error");
         }

      }

      public function setTokenToSession($token, $redirect = true) {

         // Salvar token na session
         $_SESSION["token"] = $token;

         if($redirect) {
            $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
         }

      }

      public function authenticateUser($email, $password) {
         $user = $this->findByEmail($email);

         if($user) {
            
            if(password_verify($password, $user->password)) {

               // Gerar um novo token e inserir na sessão
               $token = $user->generateToken();
               $this->setTokenToSession($token, false);

               // Atualizar token no usuário;
               $user->token = $token;
               $this->update($user, false);

               return true;

            } else {
               return false;
            }
         
         } else {
            return false;
         }

      }

      public function findByEmail($email) {
         if($email !== "") {
            $conn = $this->conn;
            $query = "SELECT * FROM users WHERE email = :email";
   
            $stmt = $conn->prepare($query);
            $stmt->execute(["email" => $email]);

            if($stmt->rowCount() > 0) {
               $data = $stmt->fetch();
               $user = $this->build($data);

               return $user;

            } else {
               return false;
            }
            
         } else {
            return false;
         }

      }

      public function findById($id) {
         if(!empty($id)) {
            $conn = $this->conn;
            $query = "SELECT * FROM users WHERE id = :id";
   
            $stmt = $conn->prepare($query);
            $stmt->execute(["id" => $id]);

            if($stmt->rowCount() > 0) {
               $data = $stmt->fetch();
               $user = $this->build($data);

               return $user;

            } else {
               return false;
            }
            
         } else {
            return false;
         }
      }

      public function findByToken($token) {
         if($token !== "") {
            $conn = $this->conn;
            $query = "SELECT * FROM users WHERE token = :token";

            $stmt = $conn->prepare($query);
            $stmt->execute(["token" => $token]);

            if($stmt->rowCount() > 0) {
               $data = $stmt->fetch();
               $user = $this->build($data);
               
               return $user;

            } else {
               return false;
            }

         } else {
            return false;
         }

      }

      public function destroyToken() {
         $_SESSION["token"] = "";

         // Redirecionar e apresentar mensagem de successo;
         $this->message->setMessage("Você foi deslogado com successo!", "success");
      }

      public function changePassword(User $user) {
         $conn = $this->conn;
         $query = "UPDATE users 
            SET password = :password
            WHERE id = :id
         ";

         $stmt = $conn->prepare($query);
         $stmt->execute([
            "password" => $user->password,
            "id" => $user->id
         ]);

         $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
      }

   }