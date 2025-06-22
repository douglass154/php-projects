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

   // Verificação do tipo do formulário
   if($type === "register") {
      $name = $type = filter_input(INPUT_POST, "name");
      $lastname = filter_input(INPUT_POST, "lastname");
      $email = filter_input(INPUT_POST, "email");
      $password = filter_input(INPUT_POST, "password");
      $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

      // Vericicação de dados mínimos
      if($name && $lastname && $email && $password) {
         
         // Verificar se as senhas coincidem
         if($password === $confirmPassword) {

            // Verificar tamanho da senha
            if(strlen($password) >= 6) {
               
               // Verificar se o e-mail já está cadastrado no email
               if($userDAO->findByEmail($email) === false) {
                  $user = new User();
                  
                  // Criação de token e senha;
                  $userToken = $user->generateToken();
                  $finalPassword = $user->generatePassword($password);

                  $user->name = $name;
                  $user->lastname = $lastname;
                  $user->email = $email;
                  $user->password = $finalPassword;
                  $user->token = $userToken;

                  $auth = true;

                  $userDAO->create($user, $auth);

               } else {
                  $message->setMessage("Este endereço de e-mail já existe.", "error", "back");
               }
   
            } else {
               $message->setMessage("A senha deve possuir no mínimo 6 caracteres", "error", "back");
            }

         } else {
            $message->setMessage("As senhas não coincidem.", "error", "back");
         }
         
      }
      else {
         // Enviar mensagem de erro, de dados faltantes
         $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
      }

   } else if($type === "login") {

      $email = filter_input(INPUT_POST, "email");
      $password = filter_input(INPUT_POST, "password");

      // Tentar autenticar o usuário
      if($userDAO->authenticateUser($email, $password)) {

         $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

      // Redireciona o usuário, caso não seja feita a autenticação
      } else {
         $message->setMessage("Usuário e/ou senha incorretos.", "error", "back");
      }

   } else {

      $message->setMessage("Informações inválidas.", "error");

   }