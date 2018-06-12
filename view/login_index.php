<form class="form-horizontal" action=<?php echo ''.$GLOBALS['appurl'].'/login/login'; ?> method="POST">
  <div class="component" data-html="true">
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput">E-Mail</label>
      <div class="col-md-4">
        <input name="email" type="email" value="" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput">Passwort</label>
      <div class="col-md-4">
        <input name="password" type="password" value="" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2" control-label'="" for="textinput">&nbsp;</label>
      <div class="col-md-4">
        <input name="send" type="submit" class="btn btn-success" value="Login">
      </div>
    </div>
  </div>
</form>