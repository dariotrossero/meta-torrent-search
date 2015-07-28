<?php
$url = $_POST["data"]["link"];
$engine = $_POST["data"]["engine"];
include_once('engines/' . $engine . '.php');
switch ($_POST["data"]["type"]) {
    case "movie":
        $destination = "torrents/movies/";
        break;
    case "tv_show":
        $destination = "torrents/series/";
        break;
    case "other":
        $destination = "torrents/other/";
        break;
}
$search_engine = new $engine();
$url = $search_engine->get_torrent($url);
$command = 'curl --compressed -o ' . $destination . basename($url) . ' ' . $url;
$command2 = 'wget -O ' . $destination . basename($url) . ' ' . $url;
$out = [];
$rv = "";
exec($command, $out, $rv);
if (file_exists($destination . basename($url)) && $rv == 0 && filesize($destination . basename($url)) > 2)
    echo 0;
else {
    exec($command2, $out, $rv);
    if (file_exists($destination . basename($url)) && $rv == 0 && filesize($destination . basename($url)) > 2)
        echo 0;
    else
        echo 1;
}


