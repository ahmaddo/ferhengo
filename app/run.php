<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.04.2017
 * Time: 02:08
 */
include_once 'class/CurlClient.php';
include_once  'class/DOMreader.php';
include_once  'class/DAO.php';
include_once  'config.php';

use \ferhengo\regex\DOMreader as DOMReader;
use \ferhengo\regex\DAO as DAO;

header('Content-type: text/html; charset=utf-8');

$link = 'http://example.com';
$dom = new DOMreader($link);


$dom->findLinks($dom->getDOM());
$inPageLinks = $dom->getLinks();
foreach ( $inPageLinks as $inPageLink) {
    if ($dom->belongToDomain($inPageLink, 'app')) $dom->addToSameDomainLinks($inPageLink);
}

$links = $dom->getSameLinks();


$dao = new DAO($config);

foreach ($links as $link) {
    $href = $link;
    $queryString = 'INSERT INTO links (value) VALUES ("'.$href.'") ;' ;
    $dao->query($queryString);
}
$dao->disconnect();
print $dao->getAffectedRows();
