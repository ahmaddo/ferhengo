<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.05.2017
 * Time: 17:21
 */

namespace ferhengo\regex;

include_once 'CurlClient.php';
require_once 'DOMreader.php';
require_once 'DAO.php';

use ferhengo\regex\DOMreader as DOMreader;

class Helper extends DAO
{

    static public function followAllTheLinks($source){

        DAO::connect();
        $links = self::getAllLinks($source);
        Helper::insertAllLinksIntoDB($links);
        DAO::disconnect();
    }

    private static function getAllLinks($source)
    {
        $dom = new DOMreader($source);
        $dom->findLinks($dom->getDOM());
        $inPageLinks = $dom->getLinks();
        foreach ( $inPageLinks as $inPageLink) {
            if ($dom->belongToDomain($inPageLink, 'wiki')) $dom->addToSameDomainLinks($inPageLink);
        }

        return $dom->getSameLinks();
    }

    public static function insertAllLinksIntoDB($links)
    {
        foreach ($links as $link) {
            $href = $link;
            $queryString = 'INSERT INTO '. DAO::$config['table'] .' (value) VALUES ("'.$href.'") ;' ;
            DAO::query($queryString);
        }
    }
    public static function markLinkAsUsed($link)
    {
        $query = 'UPDATE '. DAO::$config['table'].' SET used = 1 WHERE value = "'. $link .'"';
        DAO::query($query);
    }
}