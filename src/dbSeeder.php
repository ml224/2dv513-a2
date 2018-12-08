<?php
require_once('db.php');

class Populate_db{
    private $db;

    function __construct(Reddit_database $db){
        $this->db = $db;
        $this->db->connect_db();
    }


    public function seed_db(){
        $file = getenv('FILE_PATH');
        $stream = bzopen($file, "r");
    
        if ($stream) {
            $count = 1;

            while (($buffer = fgets($stream, 4096)) !== false && $count < 2) {

                $json = json_decode($buffer, true);
                
                $author = array_search('author', $json);
                
                $this->db->insert_author($author);            
        
                $count ++;
            }

            fclose($stream);
        }
    }
}