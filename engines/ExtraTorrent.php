<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 10:20
 */
class ExtraTorrent
{

    private $url = 'http://extratorrent.cc';
    private $name = 'ExtraTorrent';

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    public function search($query)
    {
        $url = $this->url . '/advanced_search/?with=' . $query;
        $response = file_get_contents($url);
        #table.tl>tbody tr


    }
}