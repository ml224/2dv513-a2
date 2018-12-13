<?php
ini_set('max_execution_time', 0);


require_once('./src/model/author.php');
require_once('./src/model/post.php');
require_once('./src/model/subreddit.php');

class Database_Seeder{
    private $author;
    private $db_sureddit;
    private $db_post;
    private $mysqli;

    function __construct(Reddit_database $db){
        $db->connect_db();
        $mysqli = $db->getMysqli();
        $this->mysqli = $mysqli;

        $this->author = new Author($mysqli);
        $this->db_post = new Post($mysqli);
        $this->db_subreddit = new Subreddit($mysqli);
    }


    public function seed_db(string $file_path){
        $handle = bzopen($file_path, "r");


        if ($handle) {
            $starttime = date("h:i:sa");
            $count = 0;

            while (($line = fgets($handle, 14000)) !== false) {
                $count ++;
                $json = json_decode($line, true);
                
                $this->prepareAuthor($json);
                //$this->preparePost($json);
                //$this->prepareSubreddit($json);

                
                if($count > 10000 || feof($handle))
                {
                    $this->author->executeQuery();
                    $count = 0;
                }
            }
        }

        $this->mysqli->close();

        $endtime = date("h:i:sa");
        echo "\nSTART TIME: $starttime\n";
        echo "END TIME: $endtime\n";
        fclose($handle);
     }

     private function prepareAuthor(array $result){
        $author = $result['author'];
        $this->author->addToQuery($author);
    }

    private function insert_post(array $result){
        
        $postValues = array(
            'created_utc' => date("Y-m-d H-i-s", $result['created_utc']), 
            'id' => $result['id'], 
            'name' => $result['name'], 
            'body' => $result['body'], 
            'score' => $result['score']
        );

        $this->db_post->insert_post($postValues);
    }

    private function insert_subreddit(array $result){
        $subreddit = $result['subreddit'];
        $subreddit_id = $result['subreddit_id'];
        $this->db_subreddit->insert_subreddit($subreddit, $subreddit_id);
     }

}