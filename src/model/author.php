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
        $query = "INSERT INTO author (name) VALUES $values";
        
        if(!$this->mysqli->query($query)){
            throw new Exception("query did not work!!!\n" . $this->mysqli->error);
        }

        $this->resetQuery();
    }

    public function addToQuery(string $stmt){
        $this->query .= "('$stmt'), ";
    }

    private function getQuery(){
        return substr($this->query, 0, -2);
    }

    private function resetQuery(){
        $this->query = "";
    }

}
    