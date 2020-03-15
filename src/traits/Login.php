<?php

namespace SlownLS\Twitch\Traits;

trait Login{
    /**
     * Check if user is logged
     *
     * @return boolean
     */
    protected function IsLogged() : bool
    {
        return isset($_SESSION["user"]);
    }

    /**
     * Logout user
     *
     * @return void
     */
    protected function Logout()
    {
        unset($_SESSION["user"]);
    }

    /**
     * Redirect user to login page
     *
     * @return void
     */
    protected function Login()
    {
        $arrScopes = $this->config["loginScopes"];
        $scopes = '';

        foreach ($arrScopes as $scope => $allow) {
            if( $allow ){
                $scopes .= $scope . " ";
            }
        }

        $scopes = substr($scopes, 0,-1);

        $params = array( 
            "response_type" => "code",
            "client_id" => $this->config["client"],
            "redirect_uri" => $this->config["return"],
            "force_verify" => $this->config["force_verify"],
            "scope" => $scopes
        );

        $query = http_build_query($params);

        $url = $this->urlAuthorize . "?$query";
        
        header("Location: $url");
        exit();
    }

    /**
     * Connect user to your website
     *
     * @param string $code
     * @return void
     */
    protected function Connect(string $code)
    {
        $params = array(
            "client_id" => $this->config["client"],
            "client_secret" => $this->config["secret"],
            "redirect_uri" => $this->config["return"],
            "grant_type" => "authorization_code",
            "code" => $code
        );

        $client = $this->Client();

        $response = $client->request("POST", $this->urlToken, [
            "form_params" => $params
        ]);

        $data = $this->Parse($response);
        
        if( isset($data->access_token) ){
            $response = $client->request("GET", $this->urlKraken . "user", [
                "headers" => [
                    "Accept" => "application/vnd.twitchtv.v5+json",
                    "Client-ID" => $this->config["client"],
                    "Authorization" => "OAuth " . $data->access_token
                ]
            ]);

            $dataInfos = $this->Parse($response);

            if( isset($dataInfos->_id) ){
                $_SESSION["user"] = $dataInfos;
                $_SESSION["user"]->access_token = $data->access_token;
            }                
        }                    
    }
}