<?php 
   include_once("templates/header.php");
?>

   <div class="container">
      <?php include_once("templates/backbtn.html") ?>
      <h1 id="main-title">Adicionar Novo Contato</h1>

      <form id="create-form" action="<?=$BASE_URL ?>config/process.php" method="post" autocomplete="off">
         <input type="hidden" name="type" value="create">

         <div>
            <label for="name">Nome de contato:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Digite o nome" required>   
         </div>

         <div>
            <label for="phone">Telefone de contato:</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Digite o telefone" required>   
         </div>

         <div>
            <label for="email">Email de contato:</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Digite o email" required>   
         </div>

         <div>
            <label for="observations">Observações:</label>
            <textarea class="form-control" name="observations" id="observations" placeholder="Insira as observações" rows="4"></textarea> 
         </div>

         <button type="submit" class="btn btn-primary">Cadastrar</button>
      </form>
   </div>

<?php 
   include_once("templates/footer.php");
?>