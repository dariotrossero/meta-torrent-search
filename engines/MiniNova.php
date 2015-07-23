<?php

/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 10:20
 */
class MiniNova
{

    private $url = 'http://www.mininova.org';
    public $name = 'MiniNova';

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


    private function get_links($nodeList)
    {
        $response = null;
        $links = $nodeList->getElementsByTagName('a');
        foreach ($links as $link) {

            $text = $link->getAttribute('href');

            if (preg_match('/tor/', $text)) {
                $response = $text;
                break;
            }

        }
        return $response;
    }


    public function search($query)
    {
        $url = $this->url . '/search/' . $query . '/seeds';
        $response = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(0)->getElementsByTagName('tr');
        // loop over the table rows
        $results = Array();
        $total_elements = $rows->length;
        for ($i = 1; $i < $total_elements; $i++) {
            $cols = $rows->item($i)->getElementsByTagName('td');
            $title = $cols->item(2)->getElementsByTagName('a')->item(2)->nodeValue;
            $link = $this->get_links($cols->item(2));
            $size = str_replace(chr(194), " ", $cols->item(3)->nodeValue);
            $seeds = $cols->item(4)->nodeValue;
            $peers = $cols->item(5)->nodeValue;
            $temp = str_replace("/tor/", "/get/", $link);
            $link = substr_replace($temp, "", -2);
            array_push($results, [$title, $this->getUrl() . $link, $size, $seeds, $peers]);
        }

        return $results;
    }
}