<?php
require_once '../lib/Repository.php';

class GallerieRepository
{
    protected $tablename = 'gallerie';

    public function createGallerie($uid, $name, $description){
        $query = "INSERT INTO {$this->tablename}(UID,NAME,DESCRIPTION) VALUES (?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iss',$uid,$name,$description);
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
    }
}