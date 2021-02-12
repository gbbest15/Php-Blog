<?php
session_start();
if(isset($_SESSION['chat-name'])){
    $text = $_POST['text'];
     
    $cb = fopen("log.html", 'a');
    if(isset($_SESSION['login']) && $_SESSION['user_role'] == 'admin'){
    fwrite($cb, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['user_role']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($cb);
    }else{
        fwrite($cb, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['chat-name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
        fclose($cb);
    }
}
?>