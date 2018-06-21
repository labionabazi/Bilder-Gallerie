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
        if(isset($_SESSION['uid'])) {
            header('Location: '.$GLOBALS['appurl'].'/gallerie/home');
        }else{
            $loginRepository = new LoginRepository();
            $view = new View('login_index');
            $view->title = 'Bilder-DB';
            $view->heading = 'Login';
            $view->display();
        }
    }

    public function displayErrors($errors, $location){
        $_SESSION['errors'] = $errors;
        header('Location: '.$GLOBALS['appurl'].$location);
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
            $patternEmail = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
            $patternPW = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

            if(preg_match($patternEmail, $email) === 1){

                if(preg_match($patternPW, $password) === 1){

                    if($userRepository->checkEmail($email) == null){

                        if($password == $passwortRepeat){
                            $role = 2;
                            $pw = password_hash($password, PASSWORD_DEFAULT);

                            if($userRepository->createUser($firstname,$surename,$email,$pw,$role) != null){
                                header('Location: '.$GLOBALS['appurl'].'/login');
                            }
                            else {
                                $error = true;
                                array_push($errors, "User can not been created!");
                            }
                        }else{
                            $error = true;
                            array_push($errors, "Password repeation is not correct!");
                        }
                    }
                    else{
                        $error = true;
                        array_push($errors, "Email already exists!");
                    }

                }
                else{
                    $error = true;
                    array_push($errors, "Password is not valid!");
                }

            }
            else{
                $error = true;
                array_push($errors, "Email is not valid!");
            }
        }
        if($error) {
            $this->displayErrors($errors, "/login/registration");
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
            array_push($errors, "Ungültige Login-Daten");
            $this->displayErrors($errors, "/login");
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
        if(!empty($_SESSION['uid'])) {
            session_destroy();
            header('Location: ' . $GLOBALS['appurl'] . '/login');
        }else{
                header('Location: ' . $GLOBALS['appurl'] . '/login');
            }

    }
      public function notFound(){
          $view = new View("notfound");
          $view->display();
      }
}
?>