<?php

require "vendor/autoload.php";

Use SlownLS\Twitch\User;

define("TWITCH_CLIENT", "xxxxxxxxxxx");

User::SetConfig([
    "client" => TWITCH_CLIENT,
    "secret" => "xxxxxxxxxxx",
    "return" => "http://127.0.0.1/twitch_api_v2/connect",
    "force_verify" => true,
    "loginScopes" => array(
        "user_read" => 1,
        "user_subscriptions" => 1,
        "user_follows_edit" => 1,
    )  
]);

$pages = [
    "index" => [ 
        "title" => "Home",
    ],
    "login" => [ 
        "title" => "Login",
    ],
    "dashboard" => [ 
        "title" => "Dashboard",
    ],
    "connect" => [ 
        "title" => "Connect",
    ],
    "follow" => [ 
        "title" => "Follow channel",
    ],
    "unfollow" => [ 
        "title" => "Unfollow channel",
    ],
    "logout" => [ 
        "title" => "Logout",
    ]
];


$page = "index";

if( isset($_GET["p"]) && !empty($_GET["p"]) ){
    $page = htmlspecialchars($_GET["p"]);
}

if( !isset($pages[$page]) ){
    $page = "index";
}

if( $page == "dashboard" && !User::IsLogged() ) {
    $page = "index";
}

if( isset($_POST) && !empty($_POST) ){
    if( file_exists("views/$page/post.php") ){
        require "views/$page/post.php";
    }
}

ob_start();

require "views/$page/view.php";

$content = ob_get_clean();

$title = $pages[$page]["title"];

require "views/layout.php";

?>