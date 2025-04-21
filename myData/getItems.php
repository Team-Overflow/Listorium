<?php

require_once __DIR__ . '/../login/login.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if($_GET['item'] === 'user'){
        try{
            $stmt = $pdo->query("
                SELECT userName, userSurname FROM user
                WHERE status = 'PU'
            ");
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($user);
        } 
        catch(PDOException $e){
            echo json_encode(['error' => 'Erreur lors de la récupération des données utilisateurs']);
        }
    }
    else if($_GET['item'] === 'template'){
        try{
            $stmt = $pdo->query("
                SELECT templateId, templateName, nbImages, templateCreate, templateUpdate, favorite FROM template 
                JOIN user ON template.userId = user.userId
                WHERE status = 'PU'
            ");
            $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($templates);
        } 
        catch(PDOException $e){
            echo json_encode(['error' => 'Erreur lors de la récupération des templates']);
        }
    }
}
?>