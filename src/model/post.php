<?php
ini_set('max_execution_time', 0);


class Post{
    private $mysqli;
    private $query = "";
    private $keys = array();

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function executeQuery(){
        $values = $this->getQuery();//$this->mysqli->real_escape_string($this->getQuery());
        $query = "INSERT INTO post (created_utc, id, name, body, score) VALUES $values";

        if(!$this->mysqli->query($query)){
            throw new Exception("query did not work!!!\n" . $this->mysqli->error);
        }

        $this->resetQuery();
    }

    public function addToQuery(array $row){
        $numItems = count($row);
        $count = 1;
        $values = "(";

        foreach($row as $key => $value){
            $values .= "$key='$value'";

            if($count < $numItems){
                $values .= ", ";
            }
            $count ++;
        }
        $values .= "), ";

        $this->query .= $values;
    }

    private function resetQuery(){
        $this->query = "";
    }

    private function getQuery(){
        return substr($this->query, 0, -2);
    }

}
    