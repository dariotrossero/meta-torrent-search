<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 10:20
 */
class KickAss
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
    private $url = "https://kat.cr";
    public $name = "Kickass_Torrents";

    function human_filesize($bytes, $decimals = 2) {
        $size = array('b','Kb','Mb','Gb','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }


    public function search($query)
    {
        $url = $this->url . '/json.php?q=' . $query;
        $json_response = file_get_contents($url);
        $json_obj = json_decode($json_response);
        $total_results = $json_obj->total_results;
        $pages = $total_results / 25;
        $results = Array();


        for ($i = 1; $i <= $pages; $i++) {
            foreach ($json_obj->list as $obj) {
                $link = substr($obj->torrentLink, 0, strpos($obj->torrentLink, '?'));
		$results[$link] = [$obj->title, $link, $this->human_filesize($obj->size), $obj->seeds, $obj->peers];
            }
        }
        return $results;


    }

}
