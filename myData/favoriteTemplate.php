<?php

require_once __DIR__ . '/../login/login.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    if(isset($data['templateId']) && isset($data['value'])){
        $templateId = $data['templateId'];
        $value = $data['value'];

        try{
            $stmt = $pdo->prepare("
                UPDATE template SET favorite = :value WHERE templateId = :templateId
            ");
            $stmt->bindParam(':value', $value);
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