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

    public function editPicture(){
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

    public function deletePicture(){
        if (!empty($_SESSION['uid'])) {
            $pictureRepository = new PictureRepository();
            $picture = $pictureRepository->getPictureByPID($_GET['pid']);
            // Noch in Bearbeitung
            //unlink($picture->PICTURE);
            $pictureRepository->deletePicture($_GET['pid']);
            header('Location: ' . $GLOBALS['appurl'] . '/gallerie/gallerieDetails?gid='.$_GET['gid'].'');

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

//                        $this->thumbCreator($newFileName);

                        $imagefile = "../pictures/".$newFileName;
                        $imagesize = getimagesize($imagefile);
                        $imagewidth = $imagesize[0];
                        $imageheight = $imagesize[1];
                        $imagetype = $imagesize[2];
                        //$this->createThumb("",$imagefile,400,400,"../thumbs/".$newFileName,$imagetype);
                        $this->vorschaubild_erzeugen($imagefile,"../thumbs/".$newFileName,400,400);
                        echo "hallo";


                            var_dump($tagIds);

                            // Bild in Picture speichern
                            $PictureRepository->createPictureEntry($pid, "/pictures/".$newFileName, $Title, $Description);
                            // Bilder mit Gallerie verknüpfen
                            $PictureRepository->addPictureToGallerie($gid, $pid);
                            // Tags mit Bildern verlinken
                            foreach ($tagIds as $tag) {
                                var_dump($tag->TID);
                                $TagsRepository->addTagsToPicture($pid, $tag->TID);
                            }

                    }
                    echo "Bild wurd Hochgeladen!";
                    header('Location: ' . $GLOBALS['appurl'] . '/gallerie/gallerieDetails?gid='.$_GET['gid'].'');


                }
            }
        } else {
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }
    }


    function resizePicture($file, $width, $height)
    {

        if(!file_exists($file))
            return false;

        header('Content-type: image/jpeg');

        $info = getimagesize($file);

        if($info[2] == 1)
        {
            $image = imagecreatefromgif($file);
        }
        elseif($info[2] == 2)
        {
            $image = imagecreatefromjpeg($file);
        }
        elseif($info[2] == 3)
        {
            $image = imagecreatefrompng($file);
        }
        else
        {
            return false;
        }

        if ($width && ($info[0] < $info[1]))
        {
            $width = ($height / $info[1]) * $info[0];
        }
        else
        {
            $height = ($width / $info[0]) * $info[1];
        }

        $imagetc = imagecreatetruecolor($width, $height);

        imagecopyresampled($imagetc, $image, 0, 0, 0, 0, $width, $height,
            $info[0], $info[1]);

        imagejpeg($imagetc, null, 100);

    }

    function createThumb($img_path, $img_src, $img_width , $img_height, $des_src,$imagetype)
    {
        switch ($imagetype)
        {
            // Bedeutung von $imagetype:
            // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
            case 1: // GIF
                $im = imagecreatefromgif($img_src);
                break;
            case 2: // JPEG
                $im = imagecreatefromjpeg($img_src);
                break;
            case 3: // PNG
                $im = imagecreatefrompng($img_src);
                break;
            default:
                die('Unsupported imageformat');
        }

//        $im = imagecreatefromjpeg($img_path.$img_src);
        list($src_width, $src_height) = getimagesize($img_src);
        if($src_width >= $src_height)
        {
            $new_image_width = $img_width;
            $new_image_height = $src_height * $img_width / $src_width;
        }
        if($src_width < $src_height)
        {
            $new_image_height = $img_width;
            $new_image_width = $src_width * $img_height / $src_height;
        }
        $new_image = imagecreate($new_image_width, $new_image_height);
        imagecopyresized($new_image, $im, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
        if(imagejpeg($new_image, $des_src, 100)) return true;
        else return false;
    }

    function vorschaubild_erzeugen($image, $target, $max_width, $max_height) {
        // Funktion von IT-Runde.de
        echo "hallo";
        $picsize     = getimagesize($image);
        if(($picsize[2]==1)OR($picsize[2]==2)OR($picsize[2]==3)) {
            if($picsize[2] == 1) {
                $src_img     = imagecreatefromgif($image);
            }
            if($picsize[2] == 2) {
                $quality=100;
                $src_img     = imagecreatefromjpeg($image);
            }
            if($picsize[2] == 3) {
                $quality=9;
                $src_img     = imagecreatefrompng($image);
            }
            $src_width   = $picsize[0];
            $src_height  = $picsize[1];
            $skal_vert = $max_height/$src_height;
            $skal_hor = $max_width/$src_width;
            $skal = min($skal_vert, $skal_hor);
            if ($skal > 1) {
                $skal = 1;
            }
            $dest_height = $src_height*$skal;
            $dest_width = $src_width*$skal;
            $dst_img = imagecreatetruecolor($dest_width,$dest_height);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
            if($picsize[2] == 1) {
                imagegif($dst_img, "$target");
            }
            if($picsize[2] == 2) {
                imagejpeg($dst_img, "$target", $quality);
            }
            if($picsize[2] == 3) {
                imagepng($dst_img, "$target", $quality);
            }
        }
    }
}