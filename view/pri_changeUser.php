<form class="form-horizontal" action=<?php echo ''.$GLOBALS['appurl'].'/user/changeUserData'; ?> method="POST">
    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Firstname</label>
            <div class="col-md-4">
                <input name="firstname" type="text" value="<?php echo $user->FIRSTNAME; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Surename</label>
            <div class="col-md-4">
                <input name="surename" type="text" value="<?php echo $user->SURENAME; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">E-Mail</label>
            <div class="col-md-4">
                <input name="email" type="email" value="<?php echo $user->EMAIL; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Passwort</label>
            <div class="col-md-4">
                <input name="passwort" type="password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Passwort Repeat</label>
            <div class="col-md-4">
                <input name="passwortRepeat" type="password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2" control-label'="" for="textinput"></label>
            <div class="col-md-2">
                <button name="sendData" type="submit" class="btn btn-success">Update Data</button>
            </div>
            <div class="col-md-2">
                <button name="deleteUser" type="submit" class="btn btn-danger">Delete my Account</button>
            </div>
        </div>
    </div>
</form>