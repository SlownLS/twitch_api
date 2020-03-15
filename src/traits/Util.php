<?php

namespace SlownLS\Twitch\Traits;

use GuzzleHttp\Client;

trait Util{
    /**
     * Instance of class
     *
     * @var Class
     */
    private static $instance = null;

    /**
     * Url authorize of Twitch API
     *
     * @var string
     */
    public $urlAuthorize = "https://api.twitch.tv/kraken/oauth2/authorize";

    /**
     * Url token of Twitch API
     *
     * @var string
     */
    public $urlToken = "https://id.twitch.tv/oauth2/token?";

    /**
     * Url to kraken Twitch API
     *
     * @var string
     */
    public $urlKraken = "https://api.twitch.tv/kraken/";

    /**
     * Url to helix Twitch API
     *
     * @var string
     */

    public $urlHelix = "https://api.twitch.tv/helix/";

    /**
     * Guzzle Client
     *
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * Configuration variable
     *
     * @var array
     */
    private $config = [];

    /**
     * Set config to twitch api
     *
     * @param array $config
     * @return void
     */
    protected function SetConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get guzzle client
     *
     * @return GuzzleHttp\Client
     */
    protected function Client()
    {
        if( \is_null($this->client) ){
            $this->client = new Client([
                "http_errors" => false                
            ]);
        }

        return $this->client;
    }       
    
    /**
     * Get instance of user
     *
     * @return Class
     */
    protected static function GetInstance()
    {
        if( \is_null(self::$instance) ){
            self::$instance = new self();
        }
  
        return self::$instance;
    }     

    /**
     * Parse Guzzle response
     *
     * @param [type] $response
     * @return object
     */
    protected function Parse($response) : object
    {
        return \json_decode( (string) $response->getBody() );
    }  

    public static function __callStatic($name, $arguments)
    {
        $instance = self::GetInstance();
        
        if( method_exists($instance, $name) ){
            return call_user_func_array( array($instance, $name), $arguments);
        }
    }          
}