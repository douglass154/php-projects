<?php 
   include_once("templates/header.php");
?>

   <div class="container">
      <?php include_once("templates/backbtn.html") ?>
      <h1 id="main-title">Editar Contato</h1>

      <form id="edit-form" action="<?=$BASE_URL ?>config/process.php" method="post" autocomplete="off">
         <input type="hidden" name="type" value="edit">
         <input type="hidden" name="id" value="<?=$contact["id"] ?>">

         <div>
            <label for="name">Nome de contato:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Digite o nome" value="<?=$contact["name"] ?>" required>   
         </div>

         <div>
            <label for="phone">Telefone de contato:</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Digite o telefone" value="<?=$contact["phone"] ?>" required>   
         </div>

         <div>
            <label for="email">Email de contato:</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Digite o email" value="<?=$contact["email"] ?>" required>   
         </div>

         <div>
            <label for="observations">Observações:</label>
            <textarea class="form-control" name="observations" id="observations" placeholder="Insira as observações" rows="4"><?=$contact["observations"] ?></textarea>
         </div>

         <button type="submit" class="btn btn-primary">Atualizar</button>
      </form>
   </div>

<?php 
   include_once("templates/footer.php");
?>