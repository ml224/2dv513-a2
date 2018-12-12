<?php
ini_set("auto_detect_line_endings", TRUE);

require_once('./src/model/author.php');
require_once('./src/model/post.php');
require_once('./src/model/subreddit.php');

class Database_Seeder{
    private $db_author;
    private $db_sureddit;
    private $db_post;

    function __construct(Reddit_database $db){
        $db->connect_db();
        $mysqli = $db->getMysqli();

        $this->db_author = new Author($mysqli);
        $this->db_post = new Post($mysqli);
        $this->db_subreddit = new Subreddit($mysqli);
    }


    public function seed_db(string $file_path){
        $handle = bzopen($file_path, "r");
        if ($handle) {
            $starttime = microtime();
            while (($line = fgets($handle, 14000)) !== false) {
                set_time_limit(20);

                $json = json_decode($line, true);
            
                $this->insert_author($json);
                $this->insert_post($json);
                $this->insert_subreddit($json);
            }

            $endtime = microtime();
            echo "START TIME: $starttime\n";
            echo "END TIME: $endtime\n";
            fclose($handle);
        }

     }

     private function insert_author(array $result){
        $author = $result['author'];
        $this->db_author->insert_author($author);
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