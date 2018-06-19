<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.06.2018
 * Time: 17:21
 */

echo '<div style="margin-top: 20px">
<h4>Benutzer zum Administrator ernennen</h4>';
echo '<a class="btn btn-info" href="' . $GLOBALS['appurl'] . '/admin/changeUserRole">Upgrade User to Admin</a>';
echo '</div>';

echo '<div style="margin-top: 20px">
<h4>Benutzer löschen</h4>';
echo '<a class="btn btn-info" href="' . $GLOBALS['appurl'] . '/admin/deleteUser">Delete User</a>';
echo '</div>';