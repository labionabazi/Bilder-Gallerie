<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 11:18
 */


require_once '../repository/UserRepository.php';
require_once '../repository/GallerieRepository.php';

class EntryController
{

    public function newEntry(){
        if(!empty($_SESSION['uid'])) {
            $view = new View('pri_entry_create');
            $view->title = 'Bilder-DB';
            $view->heading = 'Create Entry for Gallerie';
            $view->session = $_SESSION['uid'];
            $view->display();
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function create(){
        if(!empty($_SESSION['uid'])) {
            if ($_POST['send']){
                if(isset($_FILES['upload'])){
                    $file_name = $_FILES['upload']['name'];

                    $file_type = $_FILES['upload']['type'];

                    $file_tmp_name = $_FILES['upload']['tmp_name'];

                    $file_size = $_FILES['upload']['size'];

                    echo $file_name;
                    echo $file_type;
                    echo $file_tmp_name;
                    echo $file_size;

                }
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }
}