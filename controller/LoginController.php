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

    public function displayErrors($errors, $location){

    }

    public function create(){

        $error = false;
        $errors = [];
        if ($_POST['sendData']) {
            $userRepository = new UserRepository();
            $firstname = $_POST['firstname'];
            $surename = $_POST['surename'];
            $email = $_POST['email'];
            $password = $_POST['passwort'];
            $passwortRepeat = $_POST['passwortRepeat'];


            if($userRepository->checkEmail($_POST['email']) == null){
                if($password == $passwortRepeat){
                    $role = 2;
                    $pw = password_hash($password, PASSWORD_DEFAULT);

                    if($userRepository->createUser($firstname,$surename,$email,$pw,$role) != null){
                        header('Location: '.$GLOBALS['appurl'].'/login');
                    }
                    else {
                        $error = true;
                    }
                }else{
                    $error = true;
                }
            }
            else{
                $error = true;

            }
        }
        if($error) {

        }
    }

    public function login(){
        if ($_POST['send']){
            $error = false;
            $errors = [];
            $userRepository = new UserRepository();
            if($userRepository->checkEmail($_POST['email'])){
                $user = $userRepository->getUser($_POST['email']);
                $pw =  $_POST['password'];
                if(password_verify($pw, $user->PASSWORD)){
                    $_SESSION['uid'] = $user->UID;
                    header('Location: '.$GLOBALS['appurl'].'/gallerie/home');
                } else $error =true;
            } else $error = true;
        if($error){
            //echo "VerkaktHallo";
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

    public function logout(){
        session_destroy();

        $view = new View('login_index');
        $view->title = 'Bilder-DB';
        $view->heading = 'Login';
        $view->display();

    }

}
?>