<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 25.04.2017
 * Time: 23:44
 */

namespace ferhengo\regex;

class DAO
{
    protected static $config ;
    /* @var  \mysqli $handel*/
    private static $handel;
    private static $response;
    private static $affectedRows = 0;

    private function setConfig()
    {
        $config['host'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = '';
        $config['database'] = 'db';
        $config['table'] = 'links';

        self::$config = $config;
    }

    public static function connect()
    {
        if(!isset(self::$config['host']) || !isset(self::$config['username']) || !isset(self::$config['password']) || !isset(self::$config['database'])) {
            DAO::setConfig();
        }
        try{
            self::$handel = mysqli_connect(self::$config['host'], self::$config['username'], self::$config['password'], self::$config['database']);
            self::$handel ->query("SET NAMES 'utf8'");
        } catch (\Exception $e){
           echo 'error: please set all mySQL configurations (host, username, password, database, table)' . $e->getMessage();
        }
    }

    public static function query($SQLquery)
    {
        $SQLquery = self::checkSuffix($SQLquery);

        $request = static::$handel->query($SQLquery);
        if (is_object($request)) {
            if (isset($request->num_rows))
            self::$response = $request->fetch_all(MYSQLI_ASSOC);
        }
        if (self::$handel->affected_rows)  self::$affectedRows++;
    }

    private static function checkSuffix($query)
    {
        if (substr($query, -1) != ';') return $query . ';';
        return $query;
    }

    /**
     * @return int
     */
    public static function getAffectedRows()
    {
        return self::$affectedRows;
    }

    public static function getResponse()
    {
        return self::$response;
    }

    public static function disconnect()
    {
        self::$handel->close();
    }

}

