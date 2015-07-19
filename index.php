<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php

class KickAss
{

    private $url = "https://kat.cr";
    public $name = "Kickass Torrents";


    public function search($query)
    {
        $url = $this->url . '/json.php?q=' . $query;
        $json_response = file_get_contents($url);
        $json_obj = json_decode($json_response);
        $total_results = $json_obj->total_results;
        $pages = $total_results / 25;
        $results = Array();
        echo "<table>";
        for ($i = 1; $i <= $pages; $i++) {
            foreach ($json_obj->list as $obj) {
                echo "<tr>";
                echo "<td>$obj->title</td>";
                echo "<td>$obj->size</td>";
                $link = substr($obj->torrentLink, 0, strpos($obj->torrentLink, '?'));
                echo "<td><a href='$link'>$link</a></td>";
                echo "</tr>";
                array_push($results, [$obj->title, $link, $obj->size, $obj->seeds, $obj->peers]);
            }
        }
        echo "</table>";


    }


}

class ExtraTorrent
{

    private $url = 'http://extratorrent.cc';
    private $name = 'ExtraTorrent';


    public function search($query)
    {
        $url = $this->url . '/advanced_search/?with=' . $query;
        $response = file_get_contents($url);
        #table.tl>tbody tr


    }


}


$bar = new KickAss();
$bar->search("terminator");

?>
</body>
</html>