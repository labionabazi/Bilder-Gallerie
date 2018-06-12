<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 10.06.2018
 * Time: 14:02
 */
$baseUrl ="/m151/Bilder-Gallerie/pictures/";
echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/gallerie/gallerieDetails?gid='.$gallerie->GID.'&pid='.$picture->PID.'">Back</a>';
echo '<img src="'. $baseUrl . $picture->THUMB . '" height="100%" width="100%>';