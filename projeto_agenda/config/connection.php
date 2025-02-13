<?php 
   $host = "localhost";
   $user = "root";
   $password = "";
   $dbname = "agenda";

   try {
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   } catch(PDOException $err) {
      // Erro na conexão
      $error = $err->getMessage();

      echo "Erro: $error";
   }


?>