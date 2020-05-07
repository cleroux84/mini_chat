<?php 
    include 'pdo/userList.php'; 
?>

    <ul class="list-group listUser">
        <li class="listUser list-group-item disabled">Liste des utilisateurs</li>
            <?php foreach($users as $user): ?>
        <li class="list-group-item"><?php echo $user["nickname"];?></li>
            <?php endforeach;?>
    </ul>
    
    


    