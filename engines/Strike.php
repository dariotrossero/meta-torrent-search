<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 10:20
 */
class Strike
{
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

    private $url = "https://getstrike.net";
    public $name = "Strike";

    function human_filesize($bytes, $decimals = 2)
    {
        $size = array('b', 'Kb', 'Mb', 'Gb', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }


    public function search($query)
    {
        $url = $this->url . '/api/v2/torrents/search/?phrase=' . $query;
        $json_response = file_get_contents($url);
        $json_obj = json_decode($json_response);
        $total_results = $json_obj->results;
        $results = Array();
        foreach ($json_obj->torrents as $obj) {
            $results[$obj->torrent_hash] = [$obj->torrent_title, $obj->torrent_hash, $this->human_filesize($obj->size), $obj->seeds, $obj->leeches];
        }
        return $results;

    }

    public function get_torrent($hash)
    {
        $url = $this->url . '/api/v2/torrents/download/?hash=' . $hash;
        $json_response = file_get_contents($url);
        $json_obj = json_decode($json_response);
        return $json_obj->message;
    }
}
