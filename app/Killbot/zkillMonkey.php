<?php
/**
 * Providence Slack DankFrags Killboard pull
 * User: ed
 * Date: 08/05/15
 * Time: 23:01
 */

namespace JamylBot\Killbot;


use GuzzleHttp\Client;

/**
 * Class ZkillMonkey
 * @package JamylBot\Killbot
 */
class ZkillMonkey {

    /**
     * @var Client
     */
    protected $guzzle;

    /**
     *
     */
    public function __construct()
    {
        $this->guzzle = new Client([
            'base_url'  => config('killbot.base_url'),
            'defaults'  => [
                'headers'   => [
                    'Accept-Encoding' => 'gzip',
                ],
            ],

        ]);
    }

    public function pullCorpKills($corpId, $after = null)
    {
        $path = 'corporationID/'.$corpId.'/';
        if ($after) {
            $path .= 'afterKillID/'.$after.'/';
        }
        $path .= 'orderDirection/desc/no-items/';
        $response = $this->guzzle->get($path);
        if ( $response->getStatusCode() != 200 ) {
            \Log::warning("Zkill returned HTTP status code: ".$response->getStatusCode()." when requesting kills for corp ID ".$corpId);
        }
        return $response->json();
    }

}