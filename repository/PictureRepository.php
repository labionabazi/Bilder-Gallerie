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
    protected $tagPicture = 'tag_picture';

    // Bild in DB Speichern
    public function createPictureEntry($pid, $picture, $thumbnail ,$title, $description,$gid)
    {
        $query = "INSERT INTO {$this->tablename}(PID, PICTURE, THUMB, TITLE, DESCRIPTION, GID) VALUES (?,?,?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('issssi', $pid, $picture, $thumbnail, $title, $description, $gid);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function addPictureToGallerie($gid, $pid){
        $query = "INSERT INTO {$this->gallerieTable}(gid, pid) VALUES (?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $gid, $pid);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function updatePicture($pid, $title, $description){
        $query = "UPDATE {$this->tablename} SET TITLE = ?, DESCRIPTION = ? where PID = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi', $title, $description, $pid);
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
        $query = "select p.GID,p.PID, p.PICTURE,p.TITLE,p.DESCRIPTION, p.THUMB from {$this->tablename} p  where p.GID = ?;";
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

    public function adminDeletePicture($gid){
        $query = "DELETE FROM {$this->tablename} WHERE gid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$gid);
        $statement->execute();
    }

    public function deletePicture($pid){
        $query = "DELETE FROM {$this->tablename} WHERE pid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
        $statement->execute();
    }

    public function deletePictureGallerie($pid){
        $query = "DELETE FROM {$this->picGallTable} WHERE pid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
        $statement->execute();
    }




}