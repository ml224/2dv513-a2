<?php

class Post{
    private $mysqli;
    private $postValues = "";
    private $postKeys = "";

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function insert_post(array $attributes){
        $this->setPostValues($attributes);
        $query = "INSERT INTO post($this->postKeys) VALUES($this->postValues)";
        
        if(!$this->mysqli->query($query))
        {
            echo "Post did not get inserted.... \n";
            echo $this->mysqli->error . "\n";
        }
   
    }

    private function setPostValues(array $attributes){
        $numItems = count($attributes);
        $count = 1;

        $values = "";
        $keys = "";
        foreach($attributes as $key => $value){
            $keys .= $key;
            $values .= "'$value'";
            
            if($count < $numItems){
                $keys .= ", ";
                $values .= ", ";
            }
            $count ++;
        }
        
        $this->postKeys = $keys;
        $this->postValues = $values;
    }

}
    