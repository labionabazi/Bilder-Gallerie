<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 31.05.2018
 * Time: 10:05
 */

require_once '../repository/TagsRepository.php';

class TagsRepository
{
    protected $tablename = 'tags';
    protected $tagPicture = 'tag_picture';

    public function addTagsToPicture($pid, $tags){
        $query = "INSERT INTO {$this->tagPicture}(pid, tid) VALUES (?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii',$pid,$tags);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function insertTags($tags, $description)
    {
        $query = "INSERT INTO {$this->tablename}(TAG,DESCRIPTION) VALUES (?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ss',$tags,$description);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function selectTagIdfromTag_Picture($pid){
        $query = "SELECT TID FROM {$this->tagPicture} WHERE PID = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
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

    public function deletePictureTag($pid){
        $query = "DELETE FROM {$this->tagPicture} WHERE pid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$pid);
        $statement->execute();
    }

    public function selectTagId($tag, $desctiption)
    {

    }

    public function selectTag($tag){
        $query = "SELECT TID FROM {$this->tablename} WHERE TAG = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s',$tag);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }

    public function deleteTag($tid){
        $query = "DELETE FROM {$this->tablename} WHERE tid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$tid);
        $statement->execute();
    }
}