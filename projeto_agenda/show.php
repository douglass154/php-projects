
<?php 
   include_once("templates/header.php");
?>

   <div class="container" id="view-contact-container">
      <?php include_once("templates/backbtn.html") ?>   

      <h1 id="main-title"><?=$contact["name"] ?></h1>

      <div class="view-grid">
         <div class="contact-info-container">
            <p class="bold contact-info">Telefone:</p>
            <p><?=$contact["phone"] ?></p>
         </div>
         <div class="contact-info-container">
            <p class="bold contact-info">E-mail:</p>
            <p><?=$contact["email"] ?></p>
         </div>
         <div class="contact-info-container" id="obs-container">
            <p class="bold contact-info">Observações:</p>
            <p><?=$contact["observations"] ?></p>
         </div>
      </div>
   </div>

<?php 
   include_once("templates/footer.php");
?>