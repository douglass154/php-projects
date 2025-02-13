<?php 
   include_once("templates/header.php");
?>

   <div class="container">
      <?php if(isset($printMsg) && $printMsg !== ""): ?>
         <p id="msg"><?=$printMsg ?></p>
      <?php endif; ?>
      
      <h1 id="main-title">Minha Agenda</h1>

      <?php if(count($contacts) > 0): ?>
         <table class="table" id="contacts-table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Telefone</th>
                  <th class="hidden-email" scope="col">Email</th>
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($contacts as $contact): ?>
                  <tr>
                     <td scope="row" class="col-id"><?=$contact["id"] ?></td>
                     <td scope="row"><?=$contact["name"] ?></td>
                     <td scope="row"><?=$contact["phone"] ?></td>
                     <td class="hidden-email" scope="row"><?=$contact["email"] ?></td>
                     <td class="actions" scope="row">
                        <a href="<?=$BASE_URL ?>show.php?id=<?=$contact["id"] ?>"><i class="fas fa-eye check-icon"></i></a>
                        <a href="<?=$BASE_URL ?>edit.php?id=<?=$contact["id"] ?>"><i class="far fa-edit edit-icon"></i></a>
                        <form class="delete-form" action="<?=$BASE_URL ?>config/process.php" method="post">
                           <input type="hidden" name="type" value="delete">
                           <input type="hidden" name="id" value="<?=$contact["id"] ?>">
                           <button class="delete-btn" type="submit"><i class="fa-solid fa-trash-can delete-icon"></i></button>
                        </form>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      <?php else: ?>
         <p id="empty-list-text">Ainda não há contatos na sua agenda. <a href="<?=$BASE_URL ?>create.php">Clique para adicionar</a></p>
      <?php endif; ?>
   </div>

<?php 
   include_once("templates/footer.php");
?>