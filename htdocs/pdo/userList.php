<?php
   include 'pdo/connection.php';

    $request=$bdd->query("SELECT * FROM users");
    $users=$request->fetchAll();

    
?>