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
            try {
                var_dump($cols->item(1));
            } catch (Exception $e) {
            }

        }

    }

}
