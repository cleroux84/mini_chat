<?php 

include 'pdo/userList.php';

   
    $ip = $_SERVER['REMOTE_ADDR'];
    $datetime=date('Y-m-d H:i:s');
    $nickname = $_POST['nickname'];
        foreach($users as $user)
        {
     if($_POST['nickname']=== $user['nickname']){
        echo 'ce pseudo existe déjà';
    }
    else{ 
           
        $insertUser=$bdd->prepare('INSERT INTO users (nickname, created_at, ip_address) VALUES (?,?,?)');
        $insertUser->execute(array($nickname, $datetime, $ip));  
    }
 
  }
/* var_dump($users);  */
/* ajouter un user */

        if(isset($_POST['nickname'])AND !empty($_POST['nickname'])){  
 
    } ?>