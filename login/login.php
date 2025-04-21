<?php

function getConfig(){
    return [
        'host' => 'localhost',
        'dbname' => 'tierListData',
        'username' => 'ychauvet',
        'password' => '152911',
    ];
}

/* connexion au serveur MySQL sans base de données */
function loginMySql($host, $username, $password){
    try{
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } 
    catch(PDOException $e){
        error_log("Erreur de connexion à MySQL :" . $file);
    }
}

/* connexion à une base de données spécifique */
function loginDataBase($host, $dbname, $username, $password){
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } 
    catch(PDOException $e){
        error_log("Erreur de connexion à la base de données :" . $file);
    }
}

$config = getConfig();
$pdo = loginMySql($config['host'], $config['username'], $config['password']);
$pdo = loginDataBase($config['host'], $config['dbname'], $config['username'], $config['password']);
?>