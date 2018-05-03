<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 11:16
 */

require_once '../repository/UserRepository.php';

class UserController
{
    public function getRole($uid){

        $userRepository = new UserRepository();

        if($uid != null){
            $role = $userRepository->getRole($uid);
            return $role;
        }
        else{
            $role = 0;
        }

        return $role;
    }
}