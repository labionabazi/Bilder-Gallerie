<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 24.05.2018
 * Time: 10:12
 */

class PictureRepository
{
    protected $tablename = 'picture';
    protected $gallerieTable = 'gallerie';
    protected $picGallTable = 'gallerie_picture';

    // Bild in DB Speichern
    public function createPictureEntry($pid, $picture,$title, $description)
    {
        $query = "INSERT INTO {$this->tablename}(pid, picture,title,description) VALUES (?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('isss', $pid, $picture, $title, $description);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function addPictureToGallerie($gid, $pid){
        $query = "INSERT INTO {$this->picGallTable}(gid, pid) VALUES (?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $gid, $pid);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function maxId()
    {
        $query = "SELECT max(pid) as pid FROM {$this->tablename}";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if (!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;

    }

    public function getPictureByPID($pid)
    {
        $query = "SELECT * FROM {$this->tablename} where pid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;

    }

    public function getPicturesByGid($gid)
    {
        $query = "select GID,P.PID, PICTURE,TITLE,DESCRIPTION from {$this->picGallTable} as GP join PICTURE as P on P.PID = GP.PID where GID = ?;";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$gid);
        $statement->execute();
        $result = $statement->get_result();
        $rows = array();
        while($row =$result->fetch_object()){
            $rows[] = $row;
        }
        if(!$result) throw new Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $rows;
    }

    public function adminDeletePicture($uid){
        $query = "DELETE FROM {$this->tablename} WHERE uid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
    }

    public function deletePicture($pid){
        $query = "DELETE FROM {$this->tablename} WHERE pid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
        $statement->execute();
    }

}