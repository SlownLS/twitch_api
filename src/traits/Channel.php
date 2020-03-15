<?php

namespace SlownLS\Twitch\Traits;

use SlownLS\Twitch\Exception;

trait Channel{
    /**
     * Channel reference
     *
     * @var SlownLS\Twitch\Channel
     */
    private $channel;

    /**
     * Get if user is follower to channel
     *
     * @var boolean
     */
    private $channel_follow;

    /**
     * Get if user is subscriber to channel
     *
     * @var boolean
     */
    private $channel_subscriber;
    
    /**
     * Get if user is moderator of channel
     *
     * @var boolean
     */
    private $channel_moderator;

    /**
     * Set channel reference
     *
     * @param SlownLS\Twitch\Channel $channel
     * @return void
     */
    protected function SetChannel(\SlownLS\Twitch\Channel $channel){
        if( !$channel->HasChannel() ){ return; }

        $this->channel = $channel;


        $this->channel_follow = null;
        $this->channel_subscriber = null;
        $this->channel_moderator = null;
    }

    /**
     * Check if channel is defined
     *
     * @return boolean
     */
    protected function HasChannel() : bool
    {
        if( !isset($this->channel) || empty($this->channel) ){ return false; }

        return true;
    }

    /**
     * Check if user is follow channel
     *
     * @return boolean
     */
    protected function IsFollower() : bool
    {
        if( !\is_null($this->channel_follow) ){ return $this->channel_follow; }

        $this->channel_follow = false;

        if( !$this->IsLogged() ){ return $this->channel_follow; }
        if( !$this->HasChannel() ){ return $this->channel_follow; }

        $user = $this->GetLocalInfo("_id");
        $channel = $this->channel->GetInfos();
        $channelId = $channel->data->id;
        $client = $this->Client();

        $response = $client->request("GET", $this->urlKraken . "users/$user/follows/channels/$channelId", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"]
            ]
        ]);    

        $status = $response->getStatusCode();

        if( $status != 200 ){
            return $this->channel_follow;
        }

        $this->channel_follow = true;

        return $this->channel_follow;
    }
    
    /**
     * Check if user subscribe the channel
     *
     * @return boolean
     */
    protected function IsSubscriber() : bool
    {
        if( !\is_null($this->channel_subscriber) ){ return $this->channel_subscriber; }

        $this->channel_subscriber = false;

        if( !$this->IsLogged() ){ return $this->channel_subscriber; }
        if( !$this->HasChannel() ){ return $this->channel_subscriber; }

        $user = $this->GetLocalInfo("_id");
        $channel = $this->channel->GetInfos();
        $channelId = $channel->data->id;
        $client = $this->Client();

        $response = $client->request("GET", $this->urlKraken . "users/$user/subscriptions/$channelId", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"],
                "Authorization" => "OAuth " . $this->GetLocalInfo("access_token")
            ]
        ]);    

        $status = $response->getStatusCode();

        if( $status != 200 ){
            return $this->channel_subscriber;
        }

        $this->channel_subscriber = true;

        return $this->channel_subscriber;
    }   

    /**
     * Check if user is moderator of channel
     *
     * @return boolean
     */
    protected function IsModerator() : bool
    {
        if( !\is_null($this->channel_moderator) ){ return $this->channel_moderator; }

        $this->channel_moderator = false;

        if( !$this->IsLogged() ){ return $this->channel_moderator; }
        if( !$this->HasChannel() ){ return $this->channel_moderator; }

        $user = $this->GetLocalInfo("_id");
        $channel = $this->channel->GetInfos();
        $channelId = $channel->data->id;
        $client = $this->Client();

        $response = $client->request("GET", $this->urlKraken . "users/$user/chat/channels/$channelId?api_version=5", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"],
            ]
        ]);    

        $data = $this->Parse($response);

        $isModerator = false;

        foreach ($data->badges as $key => $value){
            if( $value->id == "moderator" ) $isModerator = true;
            if( $value->id == "broadcaster" ) $isModerator = true;
        }

        $this->channel_moderator = $isModerator;

        return $this->channel_moderator;
    } 

    /**
     * Set user follow channel
     *
     * @return boolean
     */
    protected function FollowChannel() : bool
    {
        if( !$this->IsLogged() ){ return false; }
        if( !$this->HasChannel() ){ return false; }

        if( $this->channel->GetName() == $this->GetLocalInfo("name") ){
            throw new Exception("You can't follow this channel");
        }

        $user = $this->GetLocalInfo("_id");
        $channel = $this->channel->GetInfos();
        $channelId = $channel->data->id;

        $client = $this->Client();

        $response = $client->request("PUT", $this->urlKraken . "users/$user/follows/channels/$channelId", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"],
                "Authorization" => "OAuth " . $this->GetLocalInfo("access_token")
            ]
        ]);    

        $status = $response->getStatusCode();

        if( $status == 401 ){
            throw new Exception("Insufficient authorisations, you need the scope user_follows_edit");
        }

        if( $status == 422 ){
            throw new Exception("You can't follow this channel");
        }

        if( $status != 200 ){
            return false;
        }

        return true;    
    }

    /**
     * Set user unfollow channel
     *
     * @return boolean
     */
    protected function UnFollowChannel() : bool
    {
        if( !$this->IsLogged() ){ return false; }
        if( !$this->HasChannel() ){ return false; }

        if( $this->channel->GetName() == $this->GetLocalInfo("name") ){
            throw new Exception("You can't follow this channel");
        }

        $user = $this->GetLocalInfo("_id");
        $channel = $this->channel->GetInfos();
        $channelId = $channel->data->id;
        $client = $this->Client();

        $response = $client->request("DELETE", $this->urlKraken . "users/$user/follows/channels/$channelId", [
            "headers" => [
                "Accept" => "application/vnd.twitchtv.v5+json",
                "Client-ID" => $this->config["client"],
                "Authorization" => "OAuth " . $this->GetLocalInfo("access_token")
            ]
        ]);    

        $status = $response->getStatusCode();

        if( $status == 401 ){
            throw new Exception("Insufficient authorisations, you need the scope user_follows_edit");
        }

        if( $status == 422 ){
            throw new Exception("You can't unfollow this channel");
        }

        if( $status != 200 ){
            return false;
        }

        return true;        
    }
}