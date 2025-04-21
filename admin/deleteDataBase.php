<?php

require_once __DIR__ . '/../login/login.php';

try{
    /* supprimer la base de données si elle existe */
    $config = getConfig();
    $pdo = loginMySql($config['host'], $config['username'], $config['password']);
    $dbname = $config['dbname'];
    $pdo->exec("DROP DATABASE IF EXISTS `" . addslashes($dbname) . "`");
}
catch (PDOException $e){
    error_log("Erreur de création de la base de données:" . $e->getMessage());
}
?>