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
require_once '../repository/TagsRepository.php';

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

    public function AllGalleries(){
        $gallerieRepository = new GallerieRepository();
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $view = new View('admin_gallerie_home');
                $view->title = 'Bilder-DB';
                $view->heading = 'All Galleries';
                $view->session = $_SESSION['uid'];
                $view->gallerie = $gallerieRepository->getAllGalleries();
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function AllGallerieDetails(){
        $gallerieRepository = new GallerieRepository();
        $pictureRepository = new PictureRepository();
        $userRepository = new UserRepository();
        $tagRepository = new TagsRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $view = new View('admin_gallerie_details');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin: Gallerie Details';
                $view->session = $_SESSION['uid'];
                $gallerieRepository = new GallerieRepository();
                $view->gallerie = $gallerieRepository->showGallerieDetails($_GET['gid']);
                $view->pictures = $pictureRepository->getPicturesByGid($_GET['gid']);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function galleriePublish(){
        $gallerieRepository = new GallerieRepository();
        $gid = $_GET['gid'];
        echo $gid;
        if($_GET['pub'] == 1) {
            $gallerieRepository->publishGallerie($gid);
        }
        else if($_GET['pub'] == 2){
            $gallerieRepository->deletePublishGallerie($gid);
        }
        header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGalleries');
    }

    public function AdminEditPicture(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1) {
            if (!empty($_SESSION['uid'])) {
                $pictureRepository = new PictureRepository();
                $gallerieRepository = new GallerieRepository();
                $view = new View('admin_editPicture');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin: Change Picture Entry';
                $view->session = $_SESSION['uid'];
                $view->gallerie = $gallerieRepository->showGallerieDetails($_GET['gid']);
                $view->picture = $pictureRepository->getPictureByPID($_GET['pid']);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function EditPicture(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1) {
            if (!empty($_SESSION['uid'])) {
                $pictureRepository = new PictureRepository();
                if ($_POST['send']) {
                    $title = $_POST['name'];
                    $description = $_POST['description'];
                    $pid = $_GET['pid'];
                    $gid = $_GET['gid'];

                    $pictureRepository->updatePicture($pid, $title, $description);

                    header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGallerieDetails?gid=' . $_GET['gid']);

                } else {
                    header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGallerieDetails?gid=' . $_GET['gid']);
                }


            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function AdminDeletePicture(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1) {
            if (!empty($_SESSION['uid'])) {
                $pictureRepository = new PictureRepository();
                $tagRepository = new TagsRepository();
                $picture = $pictureRepository->getPictureByPID($_GET['pid']);
                unlink("../pictures/" . $picture->PICTURE);
                unlink("../thumbs/" . $picture->PICTURE);
                $pictureRepository->deletePicture($_GET['pid']);
                $tagIds = $tagRepository->selectTagIdfromTag_Picture($_GET['pid']);

                foreach ($tagIds as $tags) {
                    $tagRepository->deleteTag($tags->TID);
                }

                header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGallerieDetails?gid=' . $_GET['gid'] . '');

            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function AdminEditGallerie(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                $gallerieRepository = new GallerieRepository();
                $gid = $_GET['gid'];
                $view = new View('admin_editGallerie');
                $view->title = 'Bilder-DB';
                $view->heading = 'Admin: Change Gallerie Data';
                $view->session = $_SESSION['uid'];
                $view->gallerie = $gallerieRepository->showGallerieDetails($gid);
                $view->display();
            } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        } else {
                header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function gallerieEditData(){
        $userRepository = new UserRepository();
        if($userRepository->getRole($_SESSION['uid'])->role == 1){
            if (!empty($_SESSION['uid'])) {
                if (isset($_POST['sendData'])) {
                    $gallerieRepository = new GallerieRepository();
                    $gid = $_GET['gid'];
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $gallerieRepository->changeGallerieDetails($name, $description, $gid);
                    header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGalleries');
                }
            }else{
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function deletePicturesandTagsfromGallerie($gid){
        $pictureRepository = new PictureRepository();
        $pictures = $pictureRepository->getPicturesByGID($gid);
        for($x=0; $x < count($pictures);$x++){
            unlink("../pictures/". $pictures[$x]->PICTURE);
            unlink("../thumbs/". $pictures[$x]->PICTURE);
        }
        $pictureRepository->deletePicturebyGID($gid);
    }


    public function gallerieDelete()
    {
        if (!empty($_SESSION['uid'])) {
            $gallerieRepository = new GallerieRepository();
            $gid = $_GET['gid'];
            $this->deletePicturesandTagsfromGallerie($gid);
            $gallerieRepository->DeleteGallerie($gid);
            header('Location: ' . $GLOBALS['appurl'] . '/admin/AllGalleries');
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }
}