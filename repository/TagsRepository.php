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
    protected $tablename = 'TAGS';
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
}