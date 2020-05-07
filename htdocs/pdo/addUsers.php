<?php 
//verifie si user existe deja
    if(!empty($_POST['nickname'])AND !empty($_POST['message'])){  
        $ip = $_SERVER['REMOTE_ADDR'];
            $datetime=date('Y-m-d H:i:s');
            $nickname = $_POST['nickname'];
        $userStatement=$bdd->prepare("SELECT * FROM users WHERE nickname= ?");
        $userStatement->execute([$_POST['nickname']]);
        
        $users=$userStatement->fetch(PDO::FETCH_ASSOC);
        
        
        if($user){

            $userId=$user['id'];
        }
        else {
//inserene nouveau user
            
    
            $insertUserStatement=$bdd->prepare('INSERT INTO users(nickname, created_at, ip_address)
                                    VALUES (?,?,?)');
            $insertUserStatement->execute([$_POST['nickname'], $datetime, $ip]);

//recupère dernier généré du user
            $userId=$bdd->lastInsertId();

        }

//insère le message
        $insertMessageStatement=$bdd->prepare('INSERT INTO messages (user_id, message, ip-address, created_at)
                                                VALUES (?,?,?,?');
        $insertMessageStatement->execute([$userId, $_POST['message'], $ip, $datetime]);

}
 