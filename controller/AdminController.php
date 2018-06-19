<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.06.2018
 * Time: 17:37
 */

require_once '../repository/UserRepository.php';
require_once '../repository/GallerieRepository.php';
require_once '../repository/PictureRepository.php';

class AdminController
{
    public function adminHome()
    {
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $view = new View('admin_homepage');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin Homepage';
                $view->session = $_SESSION['uid'];
                //$view->user = $userRepository->getUserById($_SESSION['uid']);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function changeUserRole(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $view = new View('admin_changeUserRole');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin: Change User Role';
                $view->session = $_SESSION['uid'];
                $view->users = $userRepository->getAllUsers($_SESSION['uid']);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function changeUsersRole(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                if(isset($_POST['sendData'])){
                    $userid =  intval($_POST['user']);

                    $userRepository->changeUserRole($userid, 1);

                    header('Location: ' . $GLOBALS['appurl'] . '/admin/adminHome');
                }
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function deleteUser(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $view = new View('admin_deleteUser');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin: Delete User';
                $view->session = $_SESSION['uid'];
                $view->users = $userRepository->getAllUsers($_SESSION['uid']);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function delUser(){
        $userRepository = new UserRepository();
        $gallerieRepository = new GallerieRepository();
        $pictureRepository = new PictureRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                if(isset($_POST['sendData'])){
                    $userid =  intval($_POST['user']);

                    echo "Hallo peche " . $userid;

                    $gallerien = $gallerieRepository->showGallerie($userid);

                    $picturesArray = [];
                    foreach($gallerien as $gallerie){
                        $pictures = $pictureRepository->getPicturesByGid($gallerie->GID);
                        foreach($pictures as $pic){
                            unlink("../pictures/" . $pic->PICTURE);
                            unlink("../thumbs/" . $pic->PICTURE);
                            $pictureRepository->deletePicture($pic->PID);
                        }
                    }
                    $userRepository->deleteUser($userid);


                    header('Location: ' . $GLOBALS['appurl'] . '/admin/adminHome');
                }
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

}