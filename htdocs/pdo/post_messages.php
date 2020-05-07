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

$nickname=null;
if(!empty($_COOKIE['nickname'])){
    $nickname=$_COOKIE['nickname'];
}
if(!empty($_POST['nickname'])){
    setcookie('nickname', $_POST['nickname'], time()+365*24*3600);
}

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

/* var_dump(($nickname)); */
?>
