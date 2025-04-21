<?php

require_once __DIR__ . '/../login/login.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if($data['item'] === 'template'){
        try{
            /* création de la template */
            $stmt = $pdo->prepare("
                INSERT INTO template (userId) VALUES ('1')
            ");
            $stmt->execute();

            /* récupérer l'ID du template inséré (idTemplate) */
            $templateId = $pdo->lastInsertId();

            /* création de la class "base" */
            $stmt = $pdo->prepare("
                INSERT INTO class (className, templateId) VALUES ('base', :templateId)
            ");
            $stmt->bindParam(':templateId', $templateId);
            $stmt->execute();

            echo json_encode(true);
        }
        catch(PDOException $e){
            echo json_encode(false);
        }
    }
    else{
        echo json_encode(false);
    }
}
?>