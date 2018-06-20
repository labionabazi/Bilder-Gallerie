<?php
echo '<form class="form-horizontal" action='.$GLOBALS['appurl'].'/admin/delUser'.' method="POST">
    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Select User to Delete:</label>
            <div class="col-md-4">
                <select id="user" name="user">';

foreach ($users as $user){
    echo '<option value="'.$user->UID.'">'.$user->FIRSTNAME.' '.$user->SURENAME .'</option>';
}

echo '</select>
            </div>
        </div>
            <label class="col-md-2 control-label" for="textinput"></label>
            <div class="col-md-2">
                <button name="sendData" type="submit" class="btn btn-success">Delete User</button>
            </div>
        </div>
    </div>
</form></br>';
