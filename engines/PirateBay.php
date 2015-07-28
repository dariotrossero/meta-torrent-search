<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 22/07/15
 * Time: 12:15
 */
class PirateBay
{

    private $url = 'https://thepiratebay.gd';
    private $name = 'The_Pirate_Bay';

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
        $url = $this->url . '/search/' . $query . '/0/7/0';
        $response = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(0)->getElementsByTagName('tr');


        $results = Array();
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            if ($cols->item(1) != NULL) {
                $t = $cols->item(1)->getElementsByTagName('div');
                $title=$t->item(0)->nodeValue;
                $k = $cols->item(1)->getElementsByTagName('a');
                $magnet_link = $k->item(1)->getAttribute('href');
                $seeders=$cols->item(2)->nodeValue;
                $peers=$cols->item(3)->nodeValue;
                
            //array_push($results, [$title, $magnet_link, $seeders, $peers]);
            }
		
        }
	return $results;
    }

}
