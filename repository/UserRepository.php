<?php
require_once '../lib/Repository.php';
/**
 * Datenbankschnittstelle für die User
 */
class UserRepository extends Repository
{
    protected $tablename = 'user';

    public function checkEmail($email){
        var_dump($email);
        $found = false;
        $query = "SELECT * FROM {$this->tablename} WHERE email = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s',$email);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        var_dump($result);
        if($result->num_rows > 0) $found = true;
        $result->close();
//        $row = $result->fetch_object();
//        if()
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

    public function createUser($firstname, $surename, $email, $password, $role){
        $query = "INSERT INTO {$this->tablename}(FIRSTANME,SURENAME,EMAIL,PASSWORD,ROLE) VALUES (?,?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssssi',$firstname,$surename ,$email ,$password ,$role);
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;

    }

    public function getRole($uid){
        $query = "SELECT role FROM {$this->tablename} WHERE uid = (?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }
}

?>