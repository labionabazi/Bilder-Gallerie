<?php



echo '<form class="" action="' . $GLOBALS['appurl'] . '/picture/edit?gid='.$gallerie->GID.'&pid='.$picture->PID.'" method="POST">
            <div class="component" data-html="true">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Name</label>
                    <div class="col-md-4">
                        <input name="name" type="text" value="'.$picture->TITLE.'" class="form-control">
                    </div>
                    </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Description</label>
                    <div class="col-md-4">
                        <input name="description" type="text" value="'.$picture->DESCRIPTION.'" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2" control-label\'="" for="textinput">&nbsp;</label>
                    <div class="col-md-4">
                        <input name="send" id="submitGallerie" type="submit" class="btn btn-success" value="Change">
                    </div>
                </div>
            </div>
        </form>';