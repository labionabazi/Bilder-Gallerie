<?php
if (isset($gallerie))
{
    for ($i = 0; $i < count($gallerie); $i++)
    {
        echo '<div class="card">
         <img src="" style="width:100%">
         <div class="container">
         <h4><b>' . $gallerie[$i]->NAME . '</b></h4>
         <p>' . $gallerie[$i]->DESCRIPTION . '</p>
         <a class="btn btn-primary" style="margin: 0 0 10px 0" href="' . $GLOBALS['appurl'] . '/gallerie/publicGallerieDetails?gid=' . $gallerie[$i]->GID . '">Details</a>
         </div>
         </div>';
    }
}
else
{
    echo "Es sind keine Gallerien freigegeben";
}
?>