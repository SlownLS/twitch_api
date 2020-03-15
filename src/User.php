<?php

namespace SlownLS\Twitch;

if( session_status() == PHP_SESSION_NONE ){
    session_start();
}

class User{
    use Traits\Login;
    use Traits\Channel;
    use Traits\Util;

    /**
     * Get info from user session
     *
     * @param string $key
     * @return string
     */
    protected function GetLocalInfo(string $key) : string
    {
        if( !$this->IsLogged() ){ return "Not logged!"; }

        return $_SESSION["user"]->$key;
    }

    /**
     * Get user by name
     *
     * @param [type] $userName
     * @return void
     */
    protected function GetByName($userName)
    {
        $client = $this->Client();

        $response = $client->request("GET", $this->urlHelix . "users?login=$userName", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"],
            ]
        ]);    

        $data = $this->Parse($response);

        if( !isset($data->data[0]) ){
            throw new Exception("User not found");
        }

        return $data->data[0];
    }
}