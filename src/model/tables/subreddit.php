<?php

class Subreddit{
    private $mysqli;
    private $query = "";


    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function executeQuery(){
        $values = $this->getQuery();
        $query = "INSERT IGNORE INTO subreddit (name, id) VALUES $values";

        if(!$this->mysqli->query($query)){
            throw new Exception("query did not work!!!\n" . $this->mysqli->error);
        }

        $this->resetQuery();
    }

    public function addToQuery(string $name, string $id){
        $this->query .= "('$name', '$id'), ";
    }

    private function resetQuery(){
        $this->query = "";
    }

    private function getQuery(){
        return substr($this->query, 0, -2);
    }
}