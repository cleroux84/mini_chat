<?php
   include 'pdo/connection.php';

    $request=$bdd->query("SELECT * FROM messages INNER JOIN users WHERE messages.user_id=users.id");
    $allTables=$request->fetchAll();
    var_dump($allTables);





?>