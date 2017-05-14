<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 14.05.2017
 * Time: 17:21
 */

namespace ferhengo\regex;

require_once 'DAO.php';


class Helper extends DAO
{
    public static function insertAllLinksToDB($links)
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