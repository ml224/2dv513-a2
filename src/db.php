<?php
require_once("configDotEnv.php");

class Reddit_database{
    private $mysqli;

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

    public function insert_author(string $name){
        $query = "INSERT INTO author(name) VALUES('$name')";
        if($this->mysqli->query($query))
        {
            echo "author updated successfully!";
        }
        else
        {
            echo "Author did not update as expected...";
        }
    }
}
