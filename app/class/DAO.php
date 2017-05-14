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
    /* @var  \mysqli $handel*/
    private static $handel;
    private static $response;
    private static $affectedRows = 0;

    public static function connect($config)
    {
        if(!isset($config['host']) || !isset($config['username']) || !isset($config['password']) || !isset($config['database'])) {
            throw new  \Exception('please set all sql connection data: host, username, password and database.');
        }
        try{
            self::$handel = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
            self::$handel ->query("SET NAMES 'utf8'");
        } catch (\Exception $e){
           echo 'error: ' . $e->getMessage();
        }
    }

    public static function query($SQLquery)
    {
        $request = static::$handel->query($SQLquery);
        if (is_object($request)) {
            if (isset($request->num_rows))
            self::$response = $request->fetch_assoc();
        }
        if (self::$handel->affected_rows)  self::$affectedRows++;
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

