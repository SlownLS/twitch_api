<?php use SlownLS\Twitch\User;

User::Logout();

header("Location: ./");
exit();