<?php
require_once("configDotEnv.php");
require_once("queries.php");

class DatabaseConnection{
    private $mysqli;
    private $user;
    private $host;
    private $db;
    private $pw;

    function __construct(){
        $this->user = $_ENV['DB_USER'];
        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV['DB'];
        $this->pw = $_ENV['DB_PW'];
    }

    public function setupDatabase(bool $withConstraints){
        try{
            $this->connect();
            $this->createDatabase();
            $this->connectWithDb();

            $queries = new Queries($withConstraints);
            $postQuery = $queries->getPostQuery();
            $subredditQuery = $queries->getSubredditQuery();
            
            $this->buildTable($subredditQuery);
            $this->buildTable($postQuery);
        }
        catch(Exception $e)
        {
            echo "something went wrong!... \n" . $e;
        }
        
    }

    public function connect(){
        $this->mysqli = mysqli_connect($this->host, $this->user, $this->pw);
    
        if($this->mysqli->connect_error)
        {
            throw new Exception($this->mysqli->error);
        } 
        else
        {
            echo "connected to MySQL without db!";
        }
    }

    private function connectWithDb(){
        $this->mysqli = mysqli_connect($this->host, $this->user, $this->pw, $this->db);
    
        if($this->mysqli->connect_error)
        {
            throw new Exception($this->mysqli->error);
        } 
        else
        {
            echo "connected to MySQL WITH db!";
        }
    }
   
    private function createDatabase(){

        $query = "CREATE DATABASE IF NOT EXISTS $this->db";
        if(!$this->mysqli->query($query))
        {
            throw new Exception($this->mysqli->error);
        }
    }
    
    private function buildTable(string $query){
        if(!$this->mysqli->query($query))
        {
            throw new Exception($this->mysqli->error);
        } 
        else
        {
            echo "table successfully created!";
        }
    }


    public function getMysqli(){
        return $this->mysqli;
    }

    public function closeConnection(){
        $this->mysqli->close();
    }
}
