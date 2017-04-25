<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.04.2017
 * Time: 03:02
 */
include_once 'class/CurlClient.php';
include_once  'class/DOMreader.php';

$link = 'www.welat.fm';
$dom = new \ferhengo\regex\DOMreader($link);
$dom->findLinks($dom->getDOM());
foreach ($dom->getLinks() as $link ) {
    echo '<a href="'. $link['href'] .'">'. $link['caption'] . '</a>' ;
    echo  '<br >';
}