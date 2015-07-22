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
        $destination = "/movie";
        break;
    case "tv_show":
        $destination = "/series";
        break;
    case "other":
        $destination = "/other";
        break;
}

$command = 'curl --compressed -o ' . $destination . ' ' . basename($url) . ' ' . $url;
exec($command);
