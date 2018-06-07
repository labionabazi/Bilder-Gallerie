<?php
require_once '../lib/Repository.php';

class GallerieRepository
{
    protected $tablename = 'gallerie';
    protected $gallerieUse = 'GALLERIE_USER';

    public function createGallerie($name, $description, $uid){
        $query = "INSERT INTO {$this->tablename}(NAME,DESCRIPTION,UID) VALUES (?,?, ?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi',$name,$description,$uid);
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function createGallerieUser($uid, $gid, $rid){
        $query = "INSERT INTO {$this->gallerieUse}(UID,GID,RID) VALUES (?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iii',$uid,$gid,$rid);
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

    public function getGallerieID($uid){
        $query = "SELECT gid FROM {$this->tablename} WHERE uid = (?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }

    public function selectGallerieId($name,$description,$uid){
        $query = "SELECT gid FROM {$this->tablename} WHERE name = ? and description = ? and uid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi',$name, $description,$uid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }
}