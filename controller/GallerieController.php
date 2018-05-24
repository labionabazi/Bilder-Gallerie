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
        if(!empty($_SESSION['uid'])){
            $view = new View('pri_gallerie_home');
            $view->title = 'Bilder-DB';
            $view->heading = 'Home Gallerie';
            $view->session = $_SESSION['uid'];
            $view->display();
        }
        else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }

    }

    public function createGallerie(){
        if(!empty($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $gallerieRepository = new GallerieRepository();
            if ($name != "") {
                $gallerieRepository->createGallerie($uid, $name, $description);
            }
            header('Location: ' . $GLOBALS['appurl'] . '/gallerie/home');
        }
        else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function displayErrors($errors, $location){
        $_SESSION['errors'] = $errors;
        header('Location: '.$GLOBALS['appurl'].$location);
    }

    public function newGallerie(){
        if(!empty($_SESSION['uid'])) {
            $view = new View('pri_gallerie_create');
            $view->title = 'Bilder-DB';
            $view->heading = 'Create Gallerie';
            $view->session = $_SESSION['uid'];
            $view->display();
        }else{
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }
    }


    public function gallerieDetails(){
        $view = new View('pri_gallerie_details');
        $view->title = 'Bilder-DB';
        $view->heading = 'Details';
        $view->session = $_SESSION['uid'];
        $gallerieRepository = new GallerieRepository();
        $view->gallerie = $gallerieRepository->showGallerieDetails($_GET['gid']);
        $view->display();
    }

}