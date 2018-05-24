<?php
echo '<button class="btn btn-info" style="margin: 0 0 5px 0">Add Gallerie</button>';
for($i = 0; $i < count($gallerie); $i++){
    echo '<div class="card">';
    echo '<img src="" style="width:100%">';
    echo '<div class="container">';
    echo '<h4><b>'.$gallerie[$i]->NAME.'</b></h4>';
    echo '<p>'.$gallerie[$i]->DESCRIPTION.'</p>';
    echo '<a class="btn btn-primary" style="margin: 0 0 10px 0" href="'.$GLOBALS['appurl'].'/gallerie/gallerieDetails?gid='.$gallerie[$i]->GID.'">Details</a>';
    echo '</div></div>';
}
?>



