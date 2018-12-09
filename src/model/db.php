<?php
require_once("configDotEnv.php");

class Reddit_database{
    
    public function connect_db(){
        $user = $_ENV['DB_USER'];
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB'];
        $pw = $_ENV['DB_PW'];

        $this->mysqli = mysqli_connect($host, $user, $pw, $db);
    
        if($this->mysqli->connect_error)
        {
            echo "failed to connect to MySQL:" . mysqli_connect_error();
        } 
        else
        {
            echo "connected to MySQL!";
        }
    }

    public function getMysqli(){
        return $this->mysqli;
    }
}
