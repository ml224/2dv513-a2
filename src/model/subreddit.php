<?php

class Subreddit{
    private $mysqli;

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function insert_subreddit(string $name, string $id){
        $stmt = $this->mysqli->prepare("INSERT INTO subreddit(name, id) VALUES(?, ?)");
        $stmt->bind_param("ss", $name, $id);
        
        if(!$stmt->execute())
        {
            echo "Subreddit did not get inserted.... \n";
            echo $this->mysqli->error . "\n";
        }

        $stmt->close();
    }
}