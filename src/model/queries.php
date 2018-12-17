<?php

class Queries{
    private $postQuery;
    private $subredditQuery;

    function __construct(bool $withConstraints){
        if($withConstraints)
        {
            $this->postQuery = $this->postQueryWithConstraints();
            $this->subredditQuery = $this->subredditQueryWithConstraints();
        }
        else
        {
            $this->postQuery = $this->postQueryWithoutConstraints();
            $this->subredditQuery = $this->subredditQueryWithoutConstraints();
        }
    }

    public function getSubredditQuery(){
        return $this->subredditQuery;
    }

    public function getPostQuery(){
        return $this->postQuery;
    }

    private function postQueryWithConstraints(){
        return "CREATE TABLE IF NOT EXISTS post(created_utc DATETIME NOT NULL, subreddit_id VARCHAR(50) NOT NULL, 
        id VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, body VARCHAR(40000) NOT NULL, score INT(11) NOT NULL, 
        parent_id VARCHAR(50) NOT NULL, link_id VARCHAR(50) NOT NULL, author VARCHAR(50) NOT NULL,
        PRIMARY KEY(name), FOREIGN KEY(subreddit_id) REFERENCES subreddit(id))";
    }
    
    private function postQueryWithoutConstraints(){
        return "CREATE TABLE IF NOT EXISTS post(created_utc DATETIME, subreddit_id VARCHAR(50), 
        id VARCHAR(50), name VARCHAR(50), body VARCHAR(40000), score INT(11), 
        parent_id VARCHAR(50), link_id VARCHAR(50), author VARCHAR(50))";
    }

    private function subredditQueryWithConstraints(){
        return "CREATE TABLE IF NOT EXISTS subreddit(name VARCHAR(50) NOT NULL, id VARCHAR(50) PRIMARY KEY)";
    }
    
    private function subredditQueryWithoutConstraints(){
        return "CREATE TABLE IF NOT EXISTS subreddit(name VARCHAR(50), id VARCHAR(50))";
    }
}
 