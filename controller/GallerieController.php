<?php

require_once '../repository/UserRepository.php';
require_once '../repository/GallerieRepository.php';
require_once '../repository/PictureRepository.php';
require_once '../repository/TagsRepository.php';

class GallerieController
{
    public function home()
    {
        if (!empty($_SESSION['uid'])) {
            $view = new View('pri_gallerie_home');
            $view->title = 'Bilder-DB';
            $view->heading = 'Home Gallerie';
            $view->session = $_SESSION['uid'];
            $gallerieRepository = new GallerieRepository();
            $view->gallerie = $gallerieRepository->showGallerie($_SESSION['uid']);
            $view->display();
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function createGallerie()
    {
        if (!empty($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $gallerieRepository = new GallerieRepository();
            if ($name != "") {
                $gallerieRepository->createGallerie($name, $description,$uid);
            }
            header('Location: ' . $GLOBALS['appurl'] . '/gallerie/home');
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function displayErrors($errors, $location)
    {
        $_SESSION['errors'] = $errors;
        header('Location: ' . $GLOBALS['appurl'] . $location);
    }

    public function newGallerie()
    {
        if (!empty($_SESSION['uid'])) {
            $view = new View('pri_gallerie_create');
            $view->title = 'Bilder-DB';
            $view->heading = 'Create Gallerie';
            $view->session = $_SESSION['uid'];
            $view->display();
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function gallerieDetails()
    {
        $pictureRepository = new PictureRepository();
        $tagRepository = new TagsRepository();
        $view = new View('pri_gallerie_details');
        $view->title = 'Bilder-DB';
        $view->heading = 'Details';
        $view->session = $_SESSION['uid'];
        $gallerieRepository = new GallerieRepository();
        $view->gallerie = $gallerieRepository->showGallerieDetails($_GET['gid']);
        $view->pictures = $pictureRepository->getPicturesByGid($_GET['gid']);
        $view->display();
    }

    public function publicGalleries(){
            $view = new View('pup_galleries');
            $view->title = 'Bilder-DB';
            $view->heading = 'Öffentliche Gallerien';
            $gallerieRepository = new GallerieRepository();
            $view->gallerie = $gallerieRepository->showPublicGalleries();
            $view->display();
    }

    public function publicGallerieDetails(){
        $pictureRepository = new PictureRepository();
        $tagRepository = new TagsRepository();
        $view = new View('pup_gallerie_details');
        $view->title = 'Bilder-DB';
        $view->heading = 'Details';
        $gallerieRepository = new GallerieRepository();
        $view->gallerie = $gallerieRepository->showGallerieDetails($_GET['gid']);
        $view->pictures = $pictureRepository->getPicturesByGid($_GET['gid']);
        $view->display();
    }

    public function galleriePublish(){
        $gid = $_GET['gid'];
        $gallerieRepository = new GallerieRepository();
        $gallerieRepository->publishGallerie($gid);
        header('Location: ' . $GLOBALS['appurl'] . '/gallerie/Home');
    }
}