<<<<<<< HEAD
<form action=<?php echo ''.$GLOBALS['appurl'].'/gallerie/createGallerie'; ?> method="POST">
    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Name</label>
            <div class="col-md-4">
                <input name="name" type="text" value="<?php echo $user->TITLE; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Description</label>
            <div class="col-md-4">
                <input name="description" type="text" value="<?php echo $user->DESCRIPTION; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2" control-label\'="" for="textinput">&nbsp;</label>
            <div class="col-md-4">
                <input name="send" id="submitGallerie" type="submit" class="btn btn-success" value="Create">
            </div>
        </div>
    </div>

</form>
