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
    public function getRole($uid)
    {
        $userRepository = new UserRepository();
        if ($uid != null) {
            $role = $userRepository->getRole($uid);
            return $role;
        } else {
            $role = 0;
        }
        return $role;
    }

    public function changeUser()
    {
        if (!empty($_SESSION['uid'])) {
            $userRepository = new UserRepository();
            $view = new View('pri_changeUser');
            $view->title = 'Bilder-DB';
            $view->heading = 'Change User Data';
            $view->session = $_SESSION['uid'];
            $view->user = $userRepository->getUserById($_SESSION['uid']);
            $view->display();
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function displayErrors($errors, $location){
        $_SESSION['errors'] = $errors;
        header('Location: '.$GLOBALS['appurl'].$location);
    }

    public function changeUserData()
    {
        $error = false;
        $errors = [];
        if (!empty($_SESSION['uid'])) {
            if (isset($_POST['sendData'])) {
                $userRepository = new UserRepository();
                $uid = $_SESSION['uid'];
                $email = $_POST['email'];
                $firstname = $_POST['firstname'];
                $surename = $_POST['surename'];
                $password = $_POST['passwort'];
                $passwortRepeat = $_POST['passwortRepeat'];
                $patternEmail = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
                $patternPW = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

                if (!empty($firstname)) {
                    if (!empty($surename)) {
                        if (preg_match($patternEmail, $email) == 1) {
                            if (empty($password) && empty($passwortRepeat)) {
                                $userRepository->changeUserDataWithoutPassword($uid, $email, $firstname, $surename);
                                header('Location: ' . $GLOBALS['appurl'] . '/user/changeUser');
                            } else {
                                if (preg_match($patternPW, $password)) {
                                    if ($password == $passwortRepeat) {
                                        $pw = password_hash($password, PASSWORD_DEFAULT);
                                        $userRepository->changeUserData($uid, $email, $firstname, $surename, $pw);
                                        header('Location: ' . $GLOBALS['appurl'] . '/user/changeUser');
                                    } else {
                                        $error = true;
                                        array_push($errors, "Password repetition is not correct!");
                                    }
                                } else {
                                    $error = true;
                                    array_push($errors, "Password pattern is not correct!");
                                }
                            }
                        } else {
                            $error = true;
                            array_push($errors, "email not valid !");
                        }
                    } else {
                        $error = true;
                        array_push($errors, "surename is empty !");
                    }
                } else {
                    $error = true;
                    array_push($errors, "firstname is empty !");
                }
            } else if (isset($_POST['deleteUser'])) {
                $userRepository = new UserRepository();
                $uid = $_SESSION['uid'];
                $rid = 1;

                if ($userRepository->getRoleID($uid)->role == 1) {
                    if (count($userRepository->getUsersbyRole($rid)) > 1) {
                        $userRepository->deleteUser($uid);
                        session_destroy();
                        header('Location: ' . $GLOBALS['appurl'] . '/login');
                    } else {
                        $error = true;
                        array_push($errors, "You are The last Admin. You can not delete your Account");
                    }
                } else if ($userRepository->getRoleID($uid) == 2) {
                    $userRepository->deleteUser($uid);
                    session_destroy();
                    header('Location: ' . $GLOBALS['appurl'] . '/login');
                }
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/user/changeUser');
            }
        }
        if ($error) {
            $this->displayErrors($errors, "/user/changeUser");
        }
    }
}