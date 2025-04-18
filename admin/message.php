<?php
function consoleLog($message){
    echo "<script>console.log(" . json_encode($message) . ");</script>";
}
?>