<form class="form-horizontal" action=<?php echo ''.$GLOBALS['appurl'].'/gallerie/gallerieEditData?gid=' . $gallerie->GID . ''; ?> method="POST">
    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Firstname</label>
            <div class="col-md-4">
                <input name="name" type="text" value="<?php echo $gallerie->NAME; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Surename</label>
            <div class="col-md-4">
                <textarea name="description" type="text" class="form-control"><?php echo $gallerie->DESCRIPTION; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"="" for="textinput"></label>
            <div class="col-md-2">
                <button name="sendData" type="submit" class="btn btn-success">Update Data</button>
            </div>
        </div>
    </div>
</form>