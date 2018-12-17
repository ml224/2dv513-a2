<?php
session_start();
ini_set('max_execution_time', 0);
set_time_limit(0);

require_once('./src/model/tables/post.php');
require_once('./src/model/tables/subreddit.php');

class DatabaseSeeder{
    private $subreddit;
    private $post;
    private $mysqli;

    function __construct(DatabaseConnection $db){
        $withConstraints = true;
        $db->setupDatabase($withConstraints);

        $this->mysqli = $db->getMysqli();

        $this->post = new Post($this->mysqli);
        $this->subreddit = new Subreddit($this->mysqli);
    }


    public function seed_db(string $file_path){

        $handle = bzopen($file_path, "r");
        $starttime = date("h:i:sa");
        
        if ($handle) {
            $count = 0;

            while (($line = fgets($handle)) !== false) {
                $count ++;
                $json = json_decode($line, true);
                
                $this->preparePost($json);
                $this->prepareSubreddit($json);

                
                if($count > 50000 || feof($handle))
                {
                    
                    $this->subreddit->executeQuery();
                    $this->post->executeQuery();
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

    private function preparePost(array $result) : void {
        $postValues = array(
            'created_utc' => date("Y-m-d H-i-s", $result['created_utc']), 
            'id' => $result['id'], 
            'name' => $result['name'], 
            'body' => $result['body'], 
            'score' => $result['score'],
            'author'=> $result['author'],
            'subreddit_id'=> $result['subreddit_id'],
            'parent_id'=>$result['parent_id'],
            'link_id'=>$result['link_id']
        );

        $this->post->addToQuery($postValues);
    }

    private function prepareSubreddit(array $result){
        $name = $result['subreddit'];
        $id = $result['subreddit_id'];
        $this->subreddit->addToQuery($name, $id);
     }

}