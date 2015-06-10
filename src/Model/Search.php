<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 1:18 PM
 */

namespace Clickbus\Model;

use Clickbus\Aop\Annotation\Cacheable;
use Clickbus\Aop\Annotation\Loggable;

class Search
{

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $from
     * @param $to
     * @param $engine
     * @param \DateTime $departureTime
     * @return mixed
     * @Cacheable
     * @Loggable
     */
    public function getSearch($from, $to, $engine, \DateTime $departureTime)
    {
        return $this->client->search($from , $to, $engine, $departureTime);
    }

} 