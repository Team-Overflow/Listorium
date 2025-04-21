<?php

/*
require_once __DIR__ . '/admin/deleteDataBase.php';
require_once __DIR__ . '/admin/createDataBase.php';
*/

$pageName = NULL;
/* reception de la variable pageName */
if(isset($_GET['pageName'])){
    $pageName = $_GET['pageName'];
    $file = $pageName . '.html';

    /* vérifier si le fichier existe dans le dossier actuel */
    if(file_exists($file)){
        include $file;
    } 
    else{
        error_log("Page non trouvée :" . $file);
    }
} 
else{
    /* si aucune page n'est demandée, afficher une page par défaut */
    include 'tierList/tierList.html';
}
?>