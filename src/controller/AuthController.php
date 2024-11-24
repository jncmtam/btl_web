<?php
    
    require_once __DIR__."/controller.php";
    class AuthController extends Controller{

        public function register(Request $req, Response $res){
            $queries = $req->getBody();
            $registerForm = new RegisterForm();
            $registerForm->loadData($queries);

            if(!$registerForm->validate()){ // if validate failed
                $res->renderUserView('register', [
                    'registerForm' => $registerForm
                ]);
                return;
            } else {
                $userModel = new UserModel($queries);
                $userModel->password = password_hash($queries["password"], PASSWORD_DEFAULT);
                $userModel->role = "user";
                $userModel->save();
                Application::$session->setFlashMessage('registerMessage', 'Register successfully');
                $res->redirect("/login");
            }
        }

        public function login(Request $req, Response $res){

            $loginForm = new LoginForm();
            $loginForm->loadData($req->getBody());
            if(!$loginForm->validate()){
                $res->setStatusCode(400);
                $res->renderUserView('login',[
                    'loginForm' => $loginForm
                ]);
                return;
            }
            if(!$loginForm->login()){
                Application::$session->setFlashMessage('loginMessage', 'Your password is incorrect.');
                $res->redirect('/login');
            } else {
                // save login status of client using session
                Application::login($loginForm->id, $loginForm->username, $loginForm->role);
                if($loginForm->role === "user") {
                    $res->redirect('/user');
                } else if($loginForm->role === "admin") {
                    $res->redirect('/admin');
                }

            }
        }

        public function logout(Request $req, Response $res){
            Application::logout();
            $res->redirect("/login");
        }
    }
