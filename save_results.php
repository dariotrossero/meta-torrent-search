<?php
/**
 * Created by PhpStorm.
 * User: dario
 * Date: 20/07/15
 * Time: 11:34
 */
$url = $_POST["data"];
//$filename =$url;
//file_put_contents('/tmp/'. basename($filename),file_get_contents($filename));
echo exec('wget '.$url .' -O /tmp/file.torrent');