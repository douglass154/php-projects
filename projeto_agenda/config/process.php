<?php 
   session_start();
   
   include_once("connection.php");
   include_once("url.php");

   $data = $_POST;

   // MODIFICAÇÕES NO BANCO
   if(!empty($data)) {

      // CRIAR CONTATO
      if($data["type"] === "create") {

         $name = $data["name"];
         $phone = $data["phone"];
         $email = $data["email"];
         $observations = $data["observations"];

         $query = "INSERT INTO contacts(name, phone, email, observations) VALUES(:name, :phone, :email, :observations)";
         
         $stmt = $conn->prepare($query);

         try {
            $stmt->execute([
               "name" => $name,
               "phone" => $phone,
               "email" => $email,
               "observations" => $observations
            ]);

            $_SESSION["msg"] = "Contato criado com sucesso!";

         } catch(PDOException $err) {
            $error = $err->getMessage();

            echo "Erro: $error";
         }

      } else if($data["type"] === "edit") {

         $id = $data["id"];
         $name = $data["name"];
         $phone = $data["phone"];
         $email = $data["email"];
         $observations = $data["observations"];

         $query = "UPDATE contacts
                   SET name = :name,
                       phone = :phone,
                       email = :email,
                       observations = :observations
                   WHERE id = :id";

         $stmt = $conn->prepare($query);

         try {
            $stmt->execute([
               "name" => $name,
               "phone" => $phone,
               "email" => $email,
               "observations" => $observations,
               "id" => $id
            ]);

            $_SESSION["msg"] = "Contato atualizado com sucesso!";

         } catch(PDOException $err) {
            $error = $err->getMessage();

            echo "Erro: $error";
         }

      } else if($data["type"] === "delete") {

         $id = $data["id"];

         $query = "DELETE FROM contacts WHERE id = :id";
         $stmt = $conn->prepare($query);

         try {
            $stmt->execute(["id" => $id]);

            $_SESSION["msg"] = "Contato deletado com sucesso!";

         } catch (PDOException $err) {
            $error = $err->getMessage();
            
            echo "Erro: $error";
         }

      }
      
      // REDIRECT HOME
      header("Location:". $BASE_URL ."../index.php");

   } else {
      // SELEÇÃO DE DADOS

      $id;
   
      if(!empty($_GET)) {
         $id = $_GET["id"];
      }
      
      // Return only one contact
      if(!empty($id)) {
         $query = "SELECT * FROM contacts WHERE id = :id";
         
         $stmt = $conn->prepare($query);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();

         $contact = $stmt->fetch(PDO::FETCH_ASSOC);

      } else {
         // Return all contacts
         $contacts = [];

         $query = "SELECT * FROM contacts";

         $stmt = $conn->prepare($query);
         $stmt->execute();

         $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

   }

   // FECHANDO CONEXÃO
   $conn = null;

?>