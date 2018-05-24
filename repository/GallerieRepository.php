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

    public function showGallerie($uid){
        $query = "SELECT * FROM {$this->tablename} WHERE UID = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
        $result = $statement->get_result();
        $rows = array();
        while($row = $result->fetch_object()){
            $rows[]= $row;
        }
        if(!$result) throw Exception($statement->error);
        $result->close();
        return $rows;
    }

    public function showGallerieDetails($gid){
        $query = "SELECT * FROM {$this->tablename} WHERE GID = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $gid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }
}