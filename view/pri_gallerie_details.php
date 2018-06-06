<?php
echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/newPicture?gid='.$gallerie->GID.'">Add Picture</a>';
echo '<h2>#'.$gallerie->GID.'</h2>';
echo '<h5>'.$gallerie->NAME.'</h5>';
echo '<h7>'.$gallerie->DESCRIPTION.'</h7>';
echo '<div>';
echo '</div>';

$baseUrl ="/m151/Bilder-Gallerie/pictures/";
for($i=0; $i< count($pictures);$i++) {
    echo "<div>";
    echo "<img src=" . $baseUrl . $pictures[$i]->PICTURE . ">";
    echo "<h2>".$pictures[$i]->TITLE."</h2>";
    echo "<h5>".$pictures[$i]->DESCRIPTION."</h5>";
    echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/editPicture?gid='.$gallerie->GID.'&pid='.$pictures[$i]->PID.'">Edit Picture</a>';
    echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/deletePicture?gid='.$gallerie->GID.'&pid='.$pictures[$i]->PID.'">Delete Picture</a>';
    echo "</div>";
}

?>