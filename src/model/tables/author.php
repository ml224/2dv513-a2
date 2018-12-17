<?php

class Author{
    private $mysqli;
    private $query = "";
    
    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function executeQuery(){
        $values = $this->getQuery();
        $query = "INSERT IGNORE INTO author (name) VALUES $values";
        if(!$this->mysqli->query($query)){
            throw new Exception("query did not work!!!\n" . $this->mysqli->error);
        }

        $this->resetQuery();
    }

    public function addToQuery(string $name){
        $name = $this->mysqli->real_escape_string($name);
        $this->query .= "('$name'), ";
    }

    private function getQuery(){
        return substr($this->query, 0, -2);
    }

    private function resetQuery(){
        $this->query = "";
    }

}
    