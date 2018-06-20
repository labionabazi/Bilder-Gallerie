<form class="form-horizontal" action=<?php echo ''.$GLOBALS['appurl'].'/picture/create?gid='.$gid; ?> method="POST" enctype="multipart/form-data">
    <?php if(!empty($_SESSION['UploadError'])){
        echo '<div><p>'.$_SESSION['UploadError'].'</p></div>';
    }

    ?>

    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">File</label>
            <div class="col-md-4">
                <input name="upload" type="file" class="btn btn-info">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Title</label>
            <div class="col-md-4">
                <input name="Title" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Description</label>
            <div class="col-md-4">
                <input name="Description" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Tags</label>
            <div class="col-md-4">
                <textarea id="tags" name="Tags" type="text" class="form-control"></textarea>
                <p><small>Tags mit Komma(,) Separieren!!</small></p>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-2"></p>
            <div class="col-md-4">
                <input type="submit" value="Upload Picture" name="send" class="btn btn-success">
            </div>
        </div>
    </div>
</form>