<?php
echo '<form class="form-horizontal" action='.$GLOBALS['appurl'].'/admin/changeUsersRole'.' method="POST">
    <div class="component" data-html="true">
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Select User for Admin Privileges:</label>
            <div class="col-md-4">
                <select id="user" name="user">';
                    // Get Users
                    var_dump($users);

                    foreach ($users as $user){
                        echo '<option value="'.$user->UID.'">'.$user->FIRSTNAME.' '.$user->SURENAME .'</option>';
                    }

          echo '</select>
            </div>
        </div>
            <label class="col-md-2 control-label" for="textinput"></label>
            <div class="col-md-2">
                <button name="sendData" type="submit" class="btn btn-success">Change User Privileges</button>
            </div>
        </div>
    </div>
</form></br>';
