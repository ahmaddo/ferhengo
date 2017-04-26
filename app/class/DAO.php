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
    private $handel;
    private $response;
    private $affectedRows = 0;

    function __construct($config)
    {
        if(!isset($config['host']) || !isset($config['username']) || !isset($config['password']) || !isset($config['database'])) {
            throw new  \Exception('please set all sql connection data: host, username, password and database.');
        }
        $this->connect($config);
    }

    private function connect($config)
    {
        try{
            $this->handel = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
            $this->handel ->query("SET NAMES 'utf8'");
        } catch (\Exception $e){
           echo 'error: ' . $e->getMessage();
        }
    }

    public function query($SQLquery)
    {
        $request = $this->handel->query($SQLquery);
        if (is_object($request)) {
            if (isset($request->num_rows))
            $this->response = $request->fetch_assoc();
        }
        if ($this->handel->affected_rows)  $this->affectedRows++;
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function disconnect()
    {
        $this->handel->close();
    }

}

