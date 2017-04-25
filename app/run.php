<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.04.2017
 * Time: 02:08
 */
include_once 'class/CurlClient.php';
include_once  'class/DOMreader.php';
use \ferhengo\regex\DOMreader as DOMReader;

$link = 'https://www.example.com';
$dom = new DOMreader($link);
$dom->findLinks($dom->getDOM());
$inPageLinks = $dom->getLinks();
foreach ( $inPageLinks as $inPageLink) {

    if ($dom->belongToDomain($inPageLink, 'wp')) $dom->addToSameDomainLinks($inPageLink);
}

var_dump($dom->getSameLinks());