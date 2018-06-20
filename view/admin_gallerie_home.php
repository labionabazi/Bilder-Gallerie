<?php
if (isset($gallerie))
{
    $gallerieRepositor =new GallerieRepository();
    $userRepository = new UserRepository();
    // <button id="addGallerie" class="btn btn-info">Add Gallerie</button>
//    echo '
//        <form class="form-horizontal gallerieForm hidden" action="' . $GLOBALS['appurl'] . '/gallerie/createGallerie" method="POST">
//            <div class="component" data-html="true">
//                    <div class="form-group">
//                        <label class="col-md-2 control-label" for="textinput">Name</label>
//                    <div class="col-md-4">
//                        <input name="name" type="text" value="" class="form-control">
//                    </div>
//                    </div>
//                <div class="form-group">
//                    <label class="col-md-2 control-label" for="textinput">Description</label>
//                    <div class="col-md-4">
//                        <input name="description" type="text" value="" class="form-control">
//                    </div>
//                </div>
//                <div class="form-group">
//                    <label class="col-md-2" control-label\'="" for="textinput">&nbsp;</label>
//                    <div class="col-md-4">
//                        <input name="send" id="submitGallerie" type="submit" class="btn btn-success" value="Create">
//                    </div>
//                </div>
//            </div>
//        </form>';
    for ($i = 0; $i < count($gallerie); $i++)
    {
        $user = $userRepository->getUserById($gallerie[$i]->UID);
        echo '<div class="card">
         <img src="" style="width:100%">
         <div class="container">
         <h4><b>' . $gallerie[$i]->NAME . '</b></h4>
         <p>' . $gallerie[$i]->DESCRIPTION . '</p>
         <p>User: ' . $user->FIRSTNAME . ' '.$user->SURENAME . '</p>
         <a class="btn btn-primary" style="margin: 0 0 10px 0" href="' . $GLOBALS['appurl'] . '/admin/AllGallerieDetails?gid=' . $gallerie[$i]->GID . '">Details</a>';

        if($gallerieRepositor->gallerieAlreadyPublished($gallerie[$i]->GID) == null){
            echo '<a class="btn btn-primary" style="margin: 0 0 10px 5px" href="' . $GLOBALS['appurl'] . '/admin/galleriePublish?gid=' . $gallerie[$i]->GID . '&pub=1">Gallerie Veröffentlichen</a>';
        }
        else{
            echo '<a class="btn btn-primary" style="margin: 0 0 10px 5px" href="' . $GLOBALS['appurl'] . '/admin/galleriePublish?gid=' . $gallerie[$i]->GID . '&pub=2">Gallerie nicht mehr Veröffentlichen</a>';
        }
        echo '</div>
         </div>';
    }
}
else
{
    echo "Du hast noch keine gallerien";
}
?>