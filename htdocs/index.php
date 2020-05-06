<?php

$nickname=null;
if(!empty($_COOKIE['nickname'])){
    $nickname=$_COOKIE['nickname'];
}
if(!empty($_POST['nickname'])){
    setcookie('nickname', $_POST['nickname'], time()+365*24*3600);
}



include 'pdo/connection.php';

if(!empty($_POST['nickname'])AND !empty($_POST['message'])){  
    $ip = $_SERVER['REMOTE_ADDR'];
    $datetime=date('Y-m-d H:i:s');
    $nickname = htmlspecialchars ($_POST['nickname']) ;
    $message=htmlspecialchars($_POST['message']);
    $userStatement=$bdd->prepare("SELECT * FROM users WHERE nickname= ?");
    $userStatement->execute([$_POST['nickname']]);
    
    $users=$userStatement->fetch(PDO::FETCH_ASSOC);
    
    
    if($users){

        $userId=$users['id'];
    }
    else {

    $insertUserStatement=$bdd->prepare('INSERT INTO users(nickname, created_at, ip_address)
                                        VALUES (?,?,?)');
    $insertUserStatement->execute([$_POST['nickname'], $datetime, $ip]);

    $userId=$bdd->lastInsertId();
    }

    $insertMessageStatement=$bdd->prepare('INSERT INTO messages (user_id, message, ip_address, created_at, color)
                                            VALUES (?,?,?,?,?)');
    $insertMessageStatement->execute([$userId, $_POST['message'], $ip, $datetime, ""]);
}

$allMessageStatement=$bdd->query('SELECT messages.*, users.nickname FROM messages INNER JOIN users WHERE users.id=messages.user_id');
$allMessages=$allMessageStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>Document</title>
</head>
<body>

     <div class="header">
<h1> TP Mini Chat </h1>
</div>
<div class="container row">
    <div class="col formS">
           <form action="index.php" method="post">
            <div class="input-group">
                <?php if($nickname):?>
                <input type="text" value="<?=$nickname ?>" name="nickname" id="nickname" placeholder="Entrer votre pseudo"/><br />
                <?php endif ?>
                <div class="input-group-prepend">
                </div>
            </div>
           
            <div class="form-group">
                <label for="exampleFormControlTextarea1"></label>
                <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Entrer votre message"></textarea>
                <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Envoyer</button>
            </div>
        </form>
        <div id="message">
    <ul class="listChat list-group list-group-flush">
        <h4>CHAT</h4>

    <?php foreach($allMessages as $allMessage): ?>  
        <li class="chat list-group-item"><?php echo $allMessage["created_at"].' - '.$allMessage["nickname"].' - '.$allMessage["message"];?></li>
    <?php endforeach;?>
    </ul>
    </div>            





    </div>
    <div class="col usersAside">
    <ul class="list-group listUser">
        <li class="listUser list-group-item disabled">Liste des utilisateurs</li>
        <?php 
    include 'pdo/userList.php'; 
?>
            <?php foreach($users as $user): ?>
        <li class="list-group-item"><?php echo $user["nickname"];?></li>
            <?php endforeach;?>
    </ul>
       
    </div>
      
    <script>
        setInterval('load_messages()', 500);
        function load_messages(){
            $('#messages').load('pdo/load_messages.php');
        }
        </script>





</body>
</html>