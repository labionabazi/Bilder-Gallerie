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
require_once  '../repository/TagsRepository.php';

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
        $TagsRepository = new TagsRepository();

        if(!empty($_SESSION['uid'])) {

            if ($_POST['send']){
                if(isset($_FILES['upload'])){
                    $file_name = $_FILES['upload']['name'];
                    $file_type = $_FILES['upload']['type'];
                    $file_tmp_name = $_FILES['upload']['tmp_name'];
                    $file_size = $_FILES['upload']['size'];
                    $target_dir = "../pictures/";

                    $tagString = $_POST['Tags'];
                    $Title = $_POST['Title'];
                    $Description = $_POST['Description'];


                    $tagsArray = explode(',', $tagString);
                    var_dump($Title);
                    var_dump($Description);
                    var_dump($tagsArray);

                    $tagIds = array();

                    foreach ($tagsArray as $tag){
                        if($TagsRepository->selectTag($tag) == null){
                            $TagsRepository->insertTags($tag, "");
                            $id = $TagsRepository->selectTag($tag);
                        }else{
                            $id = $TagsRepository->selectTag($tag);
                        }
                        array_push($tagIds, $id);
                    }

                    $gid = 1;
                    $pid = $PictureRepository->maxId()->pid + 1;
                    var_dump($pid);
                    $tags = "";

                    // BildUmbennenen
                    $path_parts = pathinfo($_FILES['upload']['name']);
                    var_dump( $path_parts['filename']);
                    var_dump( (string)$gid);
                    var_dump( (string)$pid);
                    var_dump( $path_parts['extension']);
                    $newFileName =  $path_parts['filename'] .strval($gid ). strval($pid ). '.' . $path_parts['extension'];

                    if(move_uploaded_file($file_tmp_name,$target_dir.$newFileName)){


                        // Bild in Picture speichern
                        $PictureRepository->createPictureEntry($pid, $target_dir.$newFileName, $Title, $Description);
                        // Bilder mit Gallerie verknüpfen
                        $PictureRepository->addPictureToGallerie($gid, $pid);
                        // Tags mit Bildern verlinken
                        foreach($tagIds as $tag){
                            $TagsRepository->addTagsToPicture($pid,$tags);
                        }

                    }
                    echo "Bild wurd Hochgeladen!";


                }
            }
        }else{
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }
}