<?php

namespace SlownLS\Twitch;

class Channel{
    use Traits\Util;

    public function __construct(string $name, string $client)
    {
        if( isset($client) && !empty($client) ){
            $this->SetConfig([ "client" => $client ]);
        }
        
        $this->SetChannel($name);
    }

    /**
     * Channel informations
     *
     * @var object
     */    
    public $channel;
    
    /**
     * Set channel to get infos
     *
     * @param string $channelName
     * @return void
     */
    public function SetChannel(string $channelName)
    {
        $this->channel = (object) [];

        $this->channel->name = $channelName;

        $client = $this->Client();

        $response = $client->request("GET", $this->urlHelix . "users?login=$channelName", [
            "headers" => [
                "Client-ID" => $this->config["client"],
            ]
        ]);
                
        $data = $this->Parse($response);
        $status = $response->getStatusCode();

        if( $status == 401 ){
            throw new Exception("Invalid Client ID");
        }

        if( isset($data->data) ){
            $data = $data->data;
        }
        
        if( !isset($data[0]) ){
            throw new Exception("Invalid channel name");
        }

        $data = $data[0];

        $this->channel->data = $data;
    }

    /**
     * Check if channel is defined
     *
     * @return boolean
     */
    public function HasChannel() : bool
    {
        if( isset($this->channel, $this->channel->data) ){ return true; }
        return false;
    }

    /**
     * Get infos of channel
     *
     * @return object
     */
    public function GetInfos() : object
    {
        if( !$this->HasChannel() ){ return (object) []; }
        return $this->channel;
    }

    /**
     * Get stream of channel
     *
     * @return void
     */
    public function GetStream()
    {
        if( !$this->HasChannel() ){ return false; }

        $channel = $this->channel->data->id;
        $client = $this->Client();

        $response = $client->request("GET", $this->urlKraken . "streams/$channel", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"]
            ]
        ]);
        
        $data = $this->Parse($response);

        if( $data->stream == NULL ){ return false; }

        return $data->stream;
    }   

    /**
     * Get name of current channel
     *
     * @return string
     */
    public function GetName() : string
    {
        if( !$this->HasChannel() ){ return "Not defined"; }

        return $this->channel->name;
    }

    public function GetDiplayName() : string 
    {
        if( !$this->HasChannel() ){ return "Not defined"; }
        
        return $this->channel->data->display_name;
    }
}