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

    public function getAllUsers($uid){
        $query = "SELECT * FROM {$this->tablename} where UID != ? and role != 1";
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

    public function changeUserRole($uid, $role){
        $query = "UPDATE {$this->tablename} SET ROLE = ? WHERE UID = ? ";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $role, $uid);
        $statement->execute();
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
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

    public function getUserById($uid){
        $query = "SELECT * FROM {$this->tablename} WHERE uid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }

    public function getUsersbyRole($rid){
        $query = "SELECT * FROM {$this->tablename} WHERE role = (?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$rid);
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

    public function createUser($firstname, $surename, $email, $password, $role){
        $query = "INSERT INTO {$this->tablename}(FIRSTNAME,SURENAME,EMAIL,PASSWORD,ROLE) VALUES (?,?,?,?,?)";
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

    public function getRoleID($uid){
        $query = "SELECT role FROM {$this->tablename} where uid = (?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$uid);
        $statement->execute();
        $result = $statement->get_result();
        if(!$result) throw Exception($statement->error);
        $row = $result->fetch_object();
        $result->close();
        return $row;
    }

    public function changeUserData($uid, $email, $firstname, $surename, $password){
        $query = "UPDATE {$this->tablename} SET EMAIL = ?, FIRSTNAME = ?, SURENAME = ?, PASSWORD = ? WHERE UID = ? ";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssssi', $email, $firstname, $surename, $password, $uid);
        $statement->execute();
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function changeUserDataWithoutPassword($uid, $email, $firstname, $surename){
        $query = "UPDATE {$this->tablename} SET EMAIL = ?, FIRSTNAME = ?, SURENAME = ? WHERE UID = ? ";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sssi', $email, $firstname, $surename, $uid);
        $statement->execute();
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
    }

    public function deleteUser($uid){
        $query = "DELETE FROM {$this->tablename} where uid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $uid);
        $statement->execute();
        if(!$statement->execute())throw Exception($statement->error);
        return $statement->insert_id;
    }
}
?>