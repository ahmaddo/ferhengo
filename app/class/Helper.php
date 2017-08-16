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

    static public function followAllTheLinks($source, $criteria){

        DAO::connect();
        $links = self::getAllLinks($source, $criteria);
        Helper::insertAllLinksIntoDB($links);
        DAO::disconnect();
    }

    private static function getAllLinks($source, $criteria)
    {
        $dom = new DOMreader($source);
        $dom->findLinks($dom->getDOM());
        $inPageLinks = $dom->getLinks();
        foreach ( $inPageLinks as $inPageLink) {
            if ($dom->belongToDomain($inPageLink, $criteria)) $dom->addToSameDomainLinks($inPageLink);
        }

        return $dom->getSameLinks();
    }

    public static function insertAllLinksIntoDB($links)
    {
        foreach ($links as $link) {
            $href = $link;
            if(!self::isPresented($link)) {
                $queryString = 'INSERT INTO '. DAO::$config['table'] .' (value) VALUES ("'.$href.'") ;' ;
                DAO::query($queryString);
            }
        }
    }

    public static function isPresented($link)
    {
        $queryString = 'SELECT * FROM '. DAO::$config['table'] .'  WHERE value = "'. $link .'";' ;
        $response = DAO::query($queryString);
        return $response->num_rows > 0;
    }


    public static function getNotAffectedLinks()
    {
        DAO::connect();
        $query = 'SELECT * FROM '. DAO::$config['table'] . ' WHERE used = 0 ;';
        DAO::query($query);
        DAO::disconnect();

        return DAO::getResponse();
    }

    public static function markLinkAsUsed($link)
    {
        $query = 'UPDATE '. DAO::$config['table'].' SET used = 1 WHERE value = "'. $link .'";';
        DAO::query($query);
    }
}