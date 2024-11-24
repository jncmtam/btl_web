<?php
    
    require_once __DIR__."/controller.php";

    class HomeController extends Controller{
        
        public function showHomePage (Request $req, Response $res){
            $res->renderUserView('homeView');
        }

        public function showAboutPage(Request $req, Response $res){
            $res->renderUserView('about');
        }

        public function showLoginPage(Request $req, Response $res){
            $res->renderUserView('login');
        }

        public function showRegisterPage(Request $req, Response $res){
            $res->renderUserView('register');
        }
        
        public function showNewsPage(Request $req, Response $res) {

            // Get data from DB
            $news = NewsModel::select();
            $data = ["news" => $news];

            // Response view
            $res->renderUserView('news', $data);
        }

        public function showServicesPage(Request $req, Response $res) {
            $userRole = Application::$session->get("userRole");

            // Get products from DB
            $products = ProductModel::select();

            $data = ["products" => $products, "userRole" => $userRole];
            $res->renderUserView('services', $data);
        }
    }