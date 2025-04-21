<?php

require_once __DIR__ . '/../login/login.php';

try{
    /* création de la base de données */
    $dbname = $config['dbname'];
    $pdo->exec("
        CREATE DATABASE $dbname
    ");
    
    /* connexion à la base de données */
    $pdo = loginDataBase($config['host'], $config['dbname'], $config['username'], $config['password']);

    /* création de la table "user" */
    $sqlCreateTable = "
        CREATE TABLE user (
            userId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userName VARCHAR(20) NOT NULL,
            userSurname VARCHAR(20) NOT NULL,
            nbTemplates INT UNSIGNED NOT NULL DEFAULT 0,
            userCreate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            userUpdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            status VARCHAR(20) NOT NULL
        )";
    $pdo->exec($sqlCreateTable);
    /* Remarque status : PU -> Principal User, FU -> Friend User, SA -> Save Account */

    /* création de la table "template" */
    $sqlCreateTable = "
        CREATE TABLE template (
            templateId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            templateName VARCHAR(20) NOT NULL DEFAULT 'newTemplate',
            nbImages INT UNSIGNED NOT NULL DEFAULT 0,
            templateCreate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            templateUpdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            favorite BOOLEAN NOT NULL DEFAULT false,
            userId INT UNSIGNED,
            FOREIGN KEY (userId) REFERENCES user (userId) ON DELETE CASCADE
        )";
    $pdo->exec($sqlCreateTable);

    /* création de la table "class" */
    $sqlCreateTable = "
        CREATE TABLE class (
            classId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            num INT UNSIGNED DEFAULT 0,
            className VARCHAR(20),
            color VARCHAR(20) NOT NULL DEFAULT 'grey',
            templateId INT UNSIGNED,
            FOREIGN KEY (templateId) REFERENCES template (templateId) ON DELETE CASCADE
        )";
    $pdo->exec($sqlCreateTable);

    /* création de la table "image" */
    $sqlCreateTable = "
        CREATE TABLE image (
            imageId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            imageName VARCHAR(20) NOT NULL,
            bin VARCHAR(20) NOT NULL,
            classId INT UNSIGNED,
            FOREIGN KEY (classId) REFERENCES class(classId) ON DELETE CASCADE
        )";
    $pdo->exec($sqlCreateTable);

    /* création de la table "class_image" */
    $sqlCreateTable = "
        CREATE TABLE user_template (
            classId INT UNSIGNED,
            imageId INT UNSIGNED,
            PRIMARY KEY (classId, imageId),
            FOREIGN KEY (classId) REFERENCES class(classId),
            FOREIGN KEY (imageId) REFERENCES image(imageId)
        )";
    $pdo->exec($sqlCreateTable);

    /* ajout de l'utilisateur principale */
    $sqlData = "
        INSERT INTO user (userName, userSurname, status) VALUES ('Principal', 'User', 'PU')
    ";
    $pdo->exec($sqlData);
}
catch (PDOException $e){
    error_log("Erreur de création de la base de données:" . $e->getMessage());
}
?>