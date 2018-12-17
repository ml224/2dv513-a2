<?php


class Post{
    private $mysqli;
    private $query = "";
    private $keys = array();

    function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function executeQuery(){
        
        $values = $this->getQuery();
        $query = "INSERT INTO post (created_utc, subreddit_id, id, name, body, score, parent_id, link_id, author) VALUES $values";

        if(!$this->mysqli->query($query)){
            throw new Exception("query did not work!!!\n" . $this->mysqli->error);
        }

        $this->resetQuery();
    }

    public function addToQuery(array $row){
        $numItems = count($row);
        $count = 1;

        $created = $row['created_utc'];
        $sub = $row['subreddit_id'];
        $id = $row['id'];
        $name = $row['name'];
        $body = $this->mysqli->real_escape_string($row['body']);
        $score = $row['score'];
        $parentId = $row['parent_id'];
        $linkId = $row['link_id'];
        $author = $row['author'];

        $values = "('$created', '$sub', '$id', '$name', '$body', '$score', '$parentId', '$linkId', '$author'), ";

        $this->query .= $values;
    }

    private function resetQuery(){
        $this->query = "";
    }

    private function getQuery(){
        return substr($this->query, 0, -2);
    }

}
    