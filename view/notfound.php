
<h1>Seite nicht gefunden... </h1>
<?php
if(isset($_SESSION['uid'])){
    echo '<a href='.$GLOBALS['appurl'].'/gallerie/home'.' class="btn btn-success">Go to Home</a>';
}else{
    echo '<a href='.$GLOBALS['appurl'].'/login/login'.' class="btn btn-success">Go to Login</a>';
}
?>
