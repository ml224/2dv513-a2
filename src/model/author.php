<?php

class Author{
    private $mysqli;

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function insert_author(string $name){
        $stmt = $this->mysqli->prepare("INSERT INTO author(name) VALUES(?)");
        $stmt->bind_param("s", $name);
        
        if(!$stmt->execute())
        {
            echo "Author did not get inserted.... \n";
            echo $this->mysqli->error . "\n";
        }

        $stmt->close();
    }

}
    