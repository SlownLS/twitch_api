<?php

Use SlownLS\Twitch\User;
Use SlownLS\Twitch\Channel;

if( isset($_GET["channel"]) ){
    $channelName = htmlspecialchars($_GET["channel"]);

    $channel = new Channel($channelName, TWITCH_CLIENT);

    User::SetChannel($channel);

    try{
        User::UnFollowChannel();
    }catch(SlownLS\Twitch\Exception $e){
        // On error
    }

    header("Location: ./?channel=$channelName");
    exit();       
}

header("Location: ./");
exit();