<?php
require_once('./src/model/author.php');
require_once('./src/model/post.php');

class Database_Seeder{
    private $db_author;
    private $db_post;

    function __construct(Reddit_database $db){
        $db->connect_db();
        $mysqli = $db->getMysqli();

        $this->db_author = new Author($mysqli);
        $this->db_post = new Post($mysqli);
    }


    public function seed_db(){
        $file = getenv('FILE_PATH');
        $stream = bzopen($file, "r");
    
        if ($stream) {
            $count = 1;

            while (($buffer = fgets($stream, 4096)) !== false && $count < 100) {
                $json = json_decode($buffer, true);
                
                $this->insert_author($json);
                $this->insert_post($json);

                
                $subreddit = $json['subreddit'];
                $subreddit_id = $json['subreddit_id'];

                $count ++;
            }

            fclose($stream);
        }

     }

     private function insert_author(array $result){
        $author = $result['author'];
        $this->db_author->insert_author($author);
     }

    private function insert_post(array $result){
        $postValues = array(
            'created_utc' => $result['created_utc'], 
            'id' => $result['id'], 
            'name' => $result['name'], 
            'body' => $result['body'], 
            'score' => $result['score']
        );

        $this->db_post->insert_post($postValues);
    }

}