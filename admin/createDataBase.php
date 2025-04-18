<?php

// Connexion à la base de données
$host = 'localhost';
$dbname = 'tierListData';
$username = 'ychauvet';
$password = '152911';

try{
    // Connexion au serveur MySQL sans spécifier de base de données
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    
    // Maintenant, se connecter à la base de données nouvellement créée
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    consoleLog("Base de données connectée avec succès !");

    // Création de la table "user" si elle n'existe pas déjà
    $sqlCreateTable = "
        CREATE TABLE IF NOT EXISTS user (
            idUser INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(255) NOT NULL,
            createUser TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updateUser TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    
    $pdo->exec($sqlCreateTable);
    consoleLog("Table 'user' créée (si elle n'existait pas).");

    // Création de la table "template" si elle n'existe pas déjà
    $sqlCreateTable = "
        CREATE TABLE IF NOT EXISTS template (
            idTemplate INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description VARCHAR(255),
            color VARCHAR(255) NOT NULL,
            createTemplate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updateTemplate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    $pdo->exec($sqlCreateTable);
    consoleLog("Table 'template' créée (si elle n'existait pas).");

    // Création de la table "user_template" si elle n'existe pas déjà
    $sqlCreateTable = "
        CREATE TABLE IF NOT EXISTS user_template (
            idUser INT UNSIGNED,
            idTemplate INT UNSIGNED,
            PRIMARY KEY (idUser, idTemplate),
            FOREIGN KEY (idUser) REFERENCES user(idUser) ON DELETE CASCADE,
            FOREIGN KEY (idTemplate) REFERENCES template(idTemplate) ON DELETE CASCADE
        )";

    $pdo->exec($sqlCreateTable);
    consoleLog("Table 'user_template' créée (si elle n'existait pas).");

    // Création de la table "class" si elle n'existe pas déjà
    $sqlCreateTable = "
        CREATE TABLE IF NOT EXISTS class (
            idClass INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            numClass INT UNSIGNED,
            name VARCHAR(255) NOT NULL,
            color VARCHAR(255) NOT NULL,
            idTemplate INT UNSIGNED,
            FOREIGN KEY (idTemplate) REFERENCES template(idTemplate) ON DELETE CASCADE
        )";

    $pdo->exec($sqlCreateTable);
    consoleLog("Table 'class' créée (si elle n'existait pas).");

    // Création de la table "image" si elle n'existe pas déjà
    $sqlCreateTable = "
        CREATE TABLE IF NOT EXISTS image (
            idImage INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            binImage VARCHAR(255) NOT NULL,
            idClass INT UNSIGNED,
            FOREIGN KEY (idClass) REFERENCES class(idClass) ON DELETE CASCADE
        )";

    $pdo->exec($sqlCreateTable);
    consoleLog("Table 'image' créée (si elle n'existait pas).");

    consoleLog("Base de données générée avec succès !");
}
catch (PDOException $e){
    consoleLog("Erreur : " . $e->getMessage());
}
?>