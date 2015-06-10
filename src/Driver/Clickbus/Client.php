<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 1:48 PM
 */

namespace Clickbus\Driver\Clickbus;

use GuzzleHttp\ClientInterface;

class Client
{

    const URL_SEARCH = '/search/';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $clientHttp;

    /**
     * @var array
     */
    protected $config;

    public function __construct($clientHttp, $config)
    {
        $this->clientHttp = $clientHttp;
        $this->config = $config;
    }

    public function search($from, $to, $engine, \DateTime $dateTime)
    {
        $uri = rtrim($this->config['base_url'], '/') . self::URL_SEARCH;
        $response = $this->clientHttp->get($uri, [
            'query' => [
                'departure' => $dateTime->format('Y-m-d'),
                'engine' => $engine,
                'from' => $from,
                'to' => $to
            ]
        ]);

        return $response->getBody()->getContents();
    }
} 