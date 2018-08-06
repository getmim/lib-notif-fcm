<?php
/**
 * Notif
 * @package lib-notif-fmc
 * @version 0.0.1
 */

namespace LibNotifFcm\Library;

use LibCurl\Library\Curl;

class Notif
{
    private static $token;
    private static $endpoint;

    static $last_result;

    private static function setAccessToken(){
        $cache_name = 'lib-notif-fcm-google-api-token';
        $token = \Mim::$app->cache->get($cache_name);

        if(!$token){
            $client = new \Google_Client();
            $client->setAuthConfig(BASEPATH . '/etc/cert/lib-notif-fcm/google-fcm.json');
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $token = $client->fetchAccessTokenWithAssertion();

            \Mim::$app->cache->add($cache_name, $token, $token['expires_in'] - 100);
        }

        self::$token = $token['access_token'];
        $project_id = \Mim::$app->config->libNotifFcm->projectId;
        self::$endpoint = 'https://fcm.googleapis.com/v1/projects/' . $project_id . '/messages:send';
    }

    static function send($body){
        if(!self::$token)
            self::setAccessToken();

        $opts = [
            'url' => self::$endpoint,
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . self::$token
            ],
            'body' => $body
        ];

        self::$last_result = $result = Curl::fetch($opts);

        return isset($result->name);
    }
}