<?php
echo '<h2>File uploading</h2>';
echo '<form action="'.$GLOBALS['appurl'].'/picture/create?gid='.$gid.'" method="post" enctype="multipart/form-data">';
echo '<p>';
echo 'File : <input type="file" name="upload">';
echo '</p>';
echo '<label for="title">Title</label> <input type="text" name="Title"><br>';
echo '<label for="Description">Description</label><input type="text" name="Description"><br>';
echo '<label for="tags">Tags:</label><textarea id="tags" name="Tags" rows="4" cols="50">';
echo '</textarea>';
echo '<p><small>Tags mit Komma(,) Separieren!!</small></p>';
echo '</br><input type="submit" value="Upload Picture" name="send">';
echo '</form></body></html>';
?>