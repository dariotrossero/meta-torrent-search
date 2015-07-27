<?php
/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 11:34
 */

$url = $_POST["data"]["link"];
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

$command = 'curl --compressed -o ' . $destination . basename($url) . ' ' . $url;
$command2 = 'wget -O ' .$destination . basename($url). ' ' .$url;
$out = [];
$rv = "";
exec($command, $out, $rv);
//analizar bien esto
if (file_exists($destination . basename($url)) && $rv == 0 && filesize($destination . basename($url)) >2)
	echo 0;
else  {
	exec($command2, $out, $rv);
	if (file_exists($destination . basename($url)) && $rv == 0  && filesize($destination . basename($url)) >2)
	echo 0;
	else
	echo 1;
}


