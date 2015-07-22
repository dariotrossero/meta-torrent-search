<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 22/07/15
 * Time: 12:15
 */
class TorrentReactor
{

    private $url = 'http://torrentreactor.com';
    private $name = 'TorrentReactor';

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
        $url = $this->url . '/torrents-search/' . $query . '?sort=seeders.desc';
        $response = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(0)->getElementsByTagName('tr');
        $results = Array();
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            if ($cols->item(1) != NULL) {
                $t = $cols->item(1)->getElementsByTagName('a');
                $link = $t->item(0)->getAttribute('href');
                if (!(substr($link, 0, 4) === "http") && preg_match('/torrents/', $link)) {
                    $title = ($t->item(0)->textContent);
                    $size = $cols->item(3)->nodeValue; //size
                    $seeds = $cols->item(4)->nodeValue; //seeds
                    $peers = $cols->item(5)->nodeValue; //peers
                    array_push($results, [$title, $link, $size, $seeds, $peers]);
                }
            }

        }
        return $results;
    }
}
