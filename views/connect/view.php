<?php use SlownLS\Twitch\User;

if( isset($_GET["code"]) && !empty($_GET["code"]) ){
    $code = htmlspecialchars($_GET["code"]);

    User::Connect($code);
}

header("Location: ./");
exit();