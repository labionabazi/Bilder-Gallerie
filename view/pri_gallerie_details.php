<?php
echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/newPicture?gid='.$gallerie->GID.'">Add Picture</a>';
echo '<h2>#'.$gallerie->GID.'</h2>';
echo '<h5>'.$gallerie->NAME.'</h5>';
echo '<h7>'.$gallerie->DESCRIPTION.'</h7>';
echo '<div>';
echo '</div>';

$baseUrl ="/m151/Bilder-Gallerie/thumbs/";
//for($i=0; $i< count($pictures);$i++) {
//    //var_dump($pictures);
//    echo "<div style='border-width: 2px; border-style: solid; padding: 2px; '>";
//    echo '<a href="'.$GLOBALS['appurl'].'/picture/showOnlyPicture?gid='.$gallerie->GID.'&pid='.$pictures[$i]->PID.'"><img src="'. $baseUrl . $pictures[$i]->THUMB . '"></a>';
//    echo "<h2>".$pictures[$i]->TITLE."</h2>";
//    echo "<h5>".$pictures[$i]->DESCRIPTION."</h5>";
//    echo "<h5>Tags: ".$pictures[$i]->TAG." </h5>";
//    echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/editPicture?gid='.$gallerie->GID.'&pid='.$pictures[$i]->PID.'">Edit Picture</a>';
//    echo '<a class="btn btn-info" href="'.$GLOBALS['appurl'].'/picture/deletePicture?gid='.$gallerie->GID.'&pid='.$pictures[$i]->PID.'">Delete Picture</a>';
//    echo "</div>";
//}
echo '<input type="text" id="mySearchInput" onkeyup="myFunction()" placeholder="Search for tags..." title="Type in a tag" style="margin: 5px">';
echo "<div id='pictures'>";
for($i=0; $i< count($pictures);$i++) {

    echo "<div style='border-width: 2px; border-style: solid; padding: 2px; height: auto; width: auto;' class='PicCards'>";
    echo '<a href="' . $GLOBALS['appurl'] . '/picture/showOnlyPicture?gid=' . $gallerie->GID . '&pid=' . $pictures[$i]->PID . '"><img src="' . $baseUrl . $pictures[$i]->THUMB . '"></a>';
    echo "<h2>" . $pictures[$i]->TITLE . "</h2>";
    echo "<h5>" . $pictures[$i]->DESCRIPTION . "</h5>";
    echo "<h5 class='tags'>Tags: " . $pictures[$i]->TAG . " </h5>";
    echo '<a class="btn btn-info" href="' . $GLOBALS['appurl'] . '/picture/editPicture?gid=' . $gallerie->GID . '&pid=' . $pictures[$i]->PID . '">Edit Picture</a>';
    echo '<a class="btn btn-info" href="' . $GLOBALS['appurl'] . '/picture/deletePicture?gid=' . $gallerie->GID . '&pid=' . $pictures[$i]->PID . '">Delete Picture</a>';
    echo "</div>";
}
echo "</div>";
echo '
<script>

function myFunction() {
    var input, filter, table, tr, td, i;
  input = document.getElementById("mySearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("pictures");
  tr = table.getElementsByClassName("PicCards");
  for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByClassName("tags")[0];
      if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
          } else {
              tr[i].style.display = "none";
          }
      }
  }
}
</script>
';

?>