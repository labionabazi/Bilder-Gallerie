<?php
require_once '../repository/LoginRepository.php';
require_once '../repository/UserRepository.php';
/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
  class LoginController
  {
    /**
     * Default-Seite für das Login: Zeigt das Login-Formular an
	 * Dispatcher: /login
     */
    public function index()
    {
        $loginRepository = new LoginRepository();
        $view = new View('login_index');
        $view->title = 'Bilder-DB';
        $view->heading = 'Login';
        $view->display();

    }

    public function create(){

    }

    public function login(){
        if ($_POST['send']){
            $error = false;
            $errors = [];
            $userRepository = new UserRepository();
            if($userRepository->checkEmail($_POST['email'])){
                $user = $userRepository->getUser($_POST['email']);
                $pwSha1 =  $_POST['password'];

                echo password_verify($pwSha1, $user->PASSWORD);
                if(password_verify(sha1('Admin'), password_hash($user->PASSWORD,PASSWORD_DEFAULT))){
                    echo "Hallo";
                    $_SESSION['uid'] =$user->uid;
                    header('Location: '.$GLOBALS['appurl'].'/galleries');
                } else $error =true;
            } else $error = true;
        if($error){
            echo "VerkaktHallo";
            array_push($errors, "Ungültige Login-Daten");
            //$this->displayErrors($errors, "/login");
        }
        }
    }


    /**
     * Zeigt das Registrations-Formular an
	 * Dispatcher: /login/registration
     */
    public function registration()
    {
      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->display();
    }
}
?>