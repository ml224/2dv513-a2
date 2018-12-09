<?php

class Author{
    private $mysqli;

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function insert_author(string $name){
        $query = "INSERT INTO author(name) VALUES('$name')";
        if(!$this->mysqli->query($query))
        {
            echo "author did not update...\n";
            echo $this->mysqli->error . "\n";
        }
    }

}
    