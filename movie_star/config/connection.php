<?php 
   $host = "localhost";
   $user = "root";
   $pass = "";
   $dbname = "moviestar";

   
   try {
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   } 
   catch(PDOException $e) {
      $error = $e->getMessage();
      echo "Erro: $error";
   }

?>