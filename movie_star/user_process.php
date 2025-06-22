<?php 
   require_once("models/User.php");
   require_once("models/Message.php");
   require_once("dao/UserDAO.php");
   require_once("globals.php");
   require_once("config/connection.php");

   $message = new Message($BASE_URL);
   $userDAO = new UserDAO($conn, $BASE_URL);

   // Resgata o tipo do formulário
   $type = filter_input(INPUT_POST, "type");

   //Atualizar usuário
   if($type === "update") {

      // Resgata dados do usuário
      $userData = $userDAO->verifyToken();

      // Receber dados do post
      $name = filter_input(INPUT_POST, "name");
      $lastname = filter_input(INPUT_POST, "lastname");
      $email = filter_input(INPUT_POST, "email");
      $bio = filter_input(INPUT_POST, "bio");

      // Criar um novo objeto de usuário
      $user = new User();

      $userData->name = $name;
      $userData->lastname = $lastname;
      $userData->email = $email;
      $userData->bio = $bio;

      // Upload da imagem
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
         $image = $_FILES["image"];
         $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
         $jpgArray = ["image/jpeg", "image/jpg"];
         
         // Checagem de tipo de imagem
         if(in_array($image["type"], $imageTypes)) {

            // Checar se é JPG
            if(in_array($image["type"], $jpgArray)) {
               $imageFile = @imagecreatefromjpeg($image["tmp_name"]);

            // Imagem é PNG
            } else {
               $imageFile = @imagecreatefrompng($image["tmp_name"]);
            }

            if($imageFile === false) {
               $message->setMessage("Erro ao processar a imagem! Verifique se o arquivo é válido.", "error", "back");
               exit;
            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./img/users/". $imageName, 100);
            imagedestroy($imageFile);

            $userData->image = $imageName;

         } else {
            $message->setMessage("O tipo da imagem é inválida, insira png ou jpg!", "error", "back");
         }

      }

      $userDAO->update($userData);
      
   // Atualizar senha do usuário
   } else if($type === "changePassword") {
      // Receber dados do post
      $password = filter_input(INPUT_POST, "password");
      $confirmPassword = filter_input(INPUT_POST, "confirmPassword");
      // Resgata dados do usuário
      $userData = $userDAO->verifyToken();
      $id = $userData->id;

      if ($password == $confirmPassword) {
         $user = new User();

         $finalPassword = $user->generatePassword($password);
         
         $user->password = $finalPassword;
         $user->id = $id;

         $userDAO->changePassword($user);

      } else {
         $message->setMessage("As senhas não coincidem, tente novamente.", "error", "back");
      }
   
   } else {
      $message->setMessage("Informações inválidas", "error");
   }