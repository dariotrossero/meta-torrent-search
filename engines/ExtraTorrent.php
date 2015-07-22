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
    public $name = 'ExtraTorrent';

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
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $tables = $dom->getElementsByTagName('table');
        $rows = $tables->item(19)->getElementsByTagName('tr');

        // loop over the table rows
        $results = Array();
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            foreach ($cols->item(0)->getElementsByTagName('a') as $a)
                $link = str_replace("torrent_", "", $this->getUrl() . $a->getAttribute('href'));
            $title = $cols->item(2)->getElementsByTagName('a')->item(1)->nodeValue;
            $size = str_replace(chr(194), " ", $cols->item(3)->nodeValue);
            $seeds = $cols->item(4)->nodeValue;
            $peers = $cols->item(5)->nodeValue;
            array_push($results, [$title, $link, $size, $seeds, $peers]);
        }

        return $results;
    }
}