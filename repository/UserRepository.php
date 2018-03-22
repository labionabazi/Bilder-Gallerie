<?php
require_once '../lib/Repository.php';
/**
 * Datenbankschnittstelle für die User
 */
class UserRepository extends Repository
{
    protected $tablename = 'user';

    public function checkEmail($email){
        $found = false;
        $query = "SELECT * FROM {$this->tablename} WHERE email = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s',$email);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        if($result->num_rows > 0) $found = true;
        $result->close();
        return $found;

    }

    public function getUser($email){
        $query = "SELECT * FROM {$this->tablename} WHERE email = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s',$email);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }
}

?>