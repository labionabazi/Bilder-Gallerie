<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 29.03.2018
 * Time: 10:16
 */

require_once '../repository/UserRepository.php';
require_once '../repository/GallerieRepository.php';

class GallerieController
{
    public function home(){
        $view = new View('pri_gallerie_home');
        $view->title = 'Bilder-DB';
        $view->heading = 'Home Gallerie';
        $view->session = $_SESSION['uid'];
        $view->display();
    }

    public function createGallerie(){
        $uid = $_SESSION['uid'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $gallerieRepository = new GallerieRepository();
        if($name != ""){
            $gallerieRepository->createGallerie($uid, $name, $description);
        }
        header('Location: '.$GLOBALS['appurl'].'/gallerie/home');
    }
}