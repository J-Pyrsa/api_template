<?php

/**
 * dp
 *
 * PHP version 7.4
 *
 * @category Class
 * @author   Erwin Palma|
 */
class DB {
    private $host = "192.168.178.35";
    private $user = "exklusive_usr";
    private $pass = "p123p123";
    private $dbname = "exklusive_db";
    private $port = "3306";

    public function connect(){
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

}