<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 11:18
 */


require_once '../repository/UserRepository.php';
require_once '../repository/GallerieRepository.php';
require_once '../repository/PictureRepository.php';

class PictureController
{

    public function newPicture(){
        if(!empty($_SESSION['uid'])) {
            $view = new View('pri_entry_create');
            $view->title = 'Bilder-DB';
            $view->heading = 'Create Entry for Gallerie';
            $view->session = $_SESSION['uid'];
            $view->gid = $_SESSION['gid'];
            $view->display();
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function create(){

        $PictureRepository = new PictureRepository();

        if(!empty($_SESSION['uid'])) {
            if ($_POST['send']){
                if(isset($_FILES['upload'])){
                    $file_name = $_FILES['upload']['name'];
                    $file_type = $_FILES['upload']['type'];
                    $file_tmp_name = $_FILES['upload']['tmp_name'];
                    $file_size = $_FILES['upload']['size'];
                    $target_dir = "../pictures/";

                    $gid = 1;
                    $pid = $PictureRepository->maxId();
                    $tags = "";

                    // BildUmbennenen
                    $path_parts = pathinfo($_FILES['upload']['name']);
                    $newFileName =  $path_parts['filename'] . strval($gid) . strval($pid) . '.' . $path_parts['extension'];


                    if(move_uploaded_file($file_tmp_name,$target_dir.$newFileName)){

                        // Bild in Picture speichern
               //         $PictureRepository->createEntry($target_dir.$newFileName, $gid, $tags);

                        // Bild in gallerie_picture

                        // Bild in tags
                        echo true;

                    }


                }
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }
}