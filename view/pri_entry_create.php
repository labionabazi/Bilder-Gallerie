<?php
echo '<h2>File uploading</h2>';
echo '<form action="'.$GLOBALS['appurl'].'/entry/create" method="post" enctype="multipart/form-data">';
echo '<p>';
echo 'File : <input type="file" name="upload">';
echo '</p>';
echo '<input type="submit" value="upload file" name="send">';
echo '</form></body></html>';
?>