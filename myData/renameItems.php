<?php

require_once __DIR__ . '/../login/login.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    if($data['item'] === 'user' && isset($data['userName']) && isset($data['userSurname'])){
        $userName = $data['userName'];
        $userSurname = $data['userSurname'];

        try{
            $stmt = $pdo->prepare("
                UPDATE user SET userName = :userName, userSurname = :userSurname
                WHERE status = 'PU'
            ");
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':userSurname', $userSurname);
            $stmt->execute();
            echo json_encode(true);
        } 
        catch(PDOException $e){
            echo json_encode(false);
        }
    }
    else if($data['item'] === 'template' && isset($data['templateId']) && isset($data['templateName'])){
        $templateId = $data['templateId'];
        $templateName = $data['templateName'];

        try{
            $stmt = $pdo->prepare("
                UPDATE template SET templateName = :templateName 
                WHERE templateId = :templateId
            ");
            $stmt->bindParam(':templateName', $templateName);
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