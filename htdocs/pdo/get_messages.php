<?php
try
{
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=mini_chat;charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


$allMessageStatement=$bdd->query('SELECT messages.*, users.nickname FROM messages INNER JOIN users WHERE users.id=messages.user_id');
$allMessages=$allMessageStatement->fetchAll(PDO::FETCH_ASSOC);
?>
 <div id="message-container">
<ul class="listChat list-group list-group-flush">
        <h4>CHAT</h4>

    <?php foreach($allMessages as $allMessage): ?>  
        <li class="chat list-group-item"><?php echo $allMessage["created_at"].' - '.$allMessage["nickname"].' - '.$allMessage["message"];?></li>
    <?php endforeach;?>
    </ul>
    </div>    