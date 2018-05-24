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
    protected $tagsGallerie = 'tags';

    // Bild in DB Specihern
    public function createEntry($picture, $gid, $tags)
    {
        $query = "INSERT INTO {$this->tablename}(picture,title,description) VALUES (?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iss', $uid, $name, $description);
        if (!$statement->execute()) throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function insertTags($tags)
    {

    }

    public function maxId()
    {
        $query = "SELECT max(pid) FROM {$this->tablename}";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if (!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;

    }

}