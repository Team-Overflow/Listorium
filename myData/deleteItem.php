<?php

require_once __DIR__ . '/../login/login.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if($data['item'] === 'template'){
        try{
            $templateId = $data['templateId'];
            $stmt = $pdo->prepare("
                DELETE FROM template WHERE templateId = :templateId
            ");
            $stmt->bindParam(':templateId', $templateId);
            $stmt->execute();
            echo json_encode(true);
        } 
        catch(PDOException $e){
            echo json_encode(false);
        }
    }
    else if($data['item'] === 'allTemplates'){
        try{
            $stmt = $pdo->prepare("
                DELETE template FROM template
                JOIN user ON template.userId = user.userId
                WHERE status = 'PU' AND favorite = 0
            ");
            $stmt->execute();
            echo json_encode(true);
        } 
        catch(PDOException $e){
            echo json_encode(false);
        }
    }
    else if($data['item'] === 'reset'){
        try{
            require_once __DIR__ . '/../admin/deleteDataBase.php';
            require_once __DIR__ . '/../admin/createDataBase.php';
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