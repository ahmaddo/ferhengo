<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.04.2017
 * Time: 02:08
 */
include_once 'class/CurlClient.php';
include_once 'class/DOMreader.php';
include_once 'class/Helper.php';
include_once  'class/DAO.php';


use \ferhengo\regex\DOMreader as DOMReader;
use \ferhengo\regex\DAO as DAO;
use \ferhengo\regex\Helper as Helper;

header('Content-type: text/html; charset=utf-8');

$link = 'http://example.com';
$dom = new DOMreader($link);


$dom->findLinks($dom->getDOM());
$inPageLinks = $dom->getLinks();
foreach ( $inPageLinks as $inPageLink) {
    if ($dom->belongToDomain($inPageLink, 'app')) $dom->addToSameDomainLinks($inPageLink);
}

$links = $dom->getSameLinks();

DAO::connect();
Helper::insertAllLinksToDB($links);
Helper::markLinkAsUsed($link);
DAO::disconnect();

print DAO::getAffectedRows();
