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
require_once '../repository/TagsRepository.php';

class PictureController
{

    public function newPicture()
    {
        if (!empty($_SESSION['uid'])) {
            $pictureRepository = new PictureRepository();
            $view = new View('pri_entry_create');
            $view->title = 'Bilder-DB';
            $view->heading = 'Create Entry for Gallerie';
            $view->session = $_SESSION['uid'];
            $view->gid = $_GET['gid'];
            $view->display();
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function editPicture()
    {
        if (!empty($_SESSION['uid'])) {
            $pictureRepository = new PictureRepository();
            $view = new View('pri_change_entry');
            $view->title = 'Bilder-DB';
            $view->heading = 'Change Picture Entry';
            $view->session = $_SESSION['uid'];
            $view->gid = $_GET['gid'];
            $view->pid = $_GET['pid'];
            $view->display();
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function edit(){
        if (!empty($_SESSION['uid'])) {
            $pictureRepository = new PictureRepository();



        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function deletePicture()
    {
        if (!empty($_SESSION['uid'])) {
            $pictureRepository = new PictureRepository();
            $tagRepository = new TagsRepository();
            $picture = $pictureRepository->getPictureByPID($_GET['pid']);
            unlink("../pictures/".$picture->PICTURE);
            unlink("../thumbs/".$picture->THUMB);
            $pictureRepository->deletePicture($_GET['pid']);
            $tagIds = $tagRepository->selectTagIdfromTag_Picture($_GET['pid']);

            foreach ($tagIds as $tags){
                $tagRepository->deleteTag($tags->TID);
            }

            header('Location: ' . $GLOBALS['appurl'] . '/gallerie/gallerieDetails?gid=' . $_GET['gid'] . '');

        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }

    public function create()
    {

        $PictureRepository = new PictureRepository();
        $TagsRepository = new TagsRepository();

        if (!empty($_SESSION['uid'])) {

            if ($_POST['send']) {
                if (isset($_FILES['upload'])) {
                    $file_name = $_FILES['upload']['name'];
                    $file_type = $_FILES['upload']['type'];
                    $file_tmp_name = $_FILES['upload']['tmp_name'];
                    $file_size = $_FILES['upload']['size'];
                    $target_dir = "../pictures/";

                    $tagString = $_POST['Tags'];
                    $Title = $_POST['Title'];
                    $Description = $_POST['Description'];

                    if(getimagesize($file_tmp_name)){

                        $tagsArray = explode(',', $tagString);
                        var_dump($Title);
                        var_dump($Description);
                        var_dump($tagsArray);

                        $tagIds = array();

                        foreach ($tagsArray as $tag) {
                            if ($TagsRepository->selectTag($tag) == null) {
                                $TagsRepository->insertTags($tag, "");
                                $id = $TagsRepository->selectTag($tag);
                            } else {
                                $id = $TagsRepository->selectTag($tag);
                            }
                            array_push($tagIds, $id);
                        }

                        $gid = $_GET['gid'];
                        $pid = $PictureRepository->maxId()->pid + 1;

                        // BildUmbennenen
                        $path_parts = pathinfo($_FILES['upload']['name']);
                        $newFileName = $path_parts['filename'] . strval($gid) . strval($pid) . '.' . $path_parts['extension'];


                        if (move_uploaded_file($file_tmp_name, $target_dir . $newFileName)) {

                            // ---------------------------------------------------------------------------------------------------------------------------------------
                            // -----------------------------------------------Erzeugung Thumbnail---------------------------------------------------------------------
                            // ---------------------------------------------------------------------------------------------------------------------------------------
                            $img = imagecreatefromjpeg("../pictures/".$newFileName);

                            $width = 200;
                            $height = 200;

                            $TNimageWidth = $width;
                            $TNimageHeight = $height;

                            $imagesx = imagesx($img);
                            $imagesy = imagesy($img);

                            if($height > $imagesy && $width > $imagesx)
                            {
                                $width = $imagesx;
                                $height = $imagesy;
                            }

                            if($imagesx / $imagesy >= $TNimageWidth / $TNimageHeight)
                            {
                                $height = round(($width / $imagesx) * $imagesy);
                            }
                            else
                            {
                                $width = round(($height / $imagesy) * $imagesx);
                            }

                            $thumbnail = imagecreatetruecolor($TNimageHeight ,$TNimageWidth );

                            imagecopyresampled($thumbnail, $img, 0, 0, 0, 0, $width, $height, $imagesx, $imagesy);
                            imagejpeg($thumbnail,"../thumbs/".$thumbnail);

                            imagedestroy($thumbnail);
                            imagedestroy($img);
                            // ---------------------------------------------------------------------------------------------------------------------------------------

                            $thumbstr = (string)$thumbnail;

                            // Bild in Picture speichern
                            $PictureRepository->createPictureEntry($pid, $newFileName, $thumbstr, $Title, $Description);
                            // Bilder mit Gallerie verknüpfen
                            $PictureRepository->addPictureToGallerie($gid, $pid);
                            // Tags mit Bildern verlinken
                            foreach ($tagIds as $tag) {
                                var_dump($tag->TID);
                                $TagsRepository->addTagsToPicture($pid, $tag->TID);
                            }

                        }
//                        echo "Bild wurd Hochgeladen!";
                        header('Location: ' . $GLOBALS['appurl'] . '/gallerie/gallerieDetails?gid=' . $_GET['gid']);


                    }
                    else {
                        echo "error";
                    }
                }
            }
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }
}