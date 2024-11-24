<?php
    
    class Response{

        public View $view;

        public function __construct()
        {
            $this->view = new View();
        }

        public function setStatusCode($code){
            http_response_code($code);
        }

        public function renderUserView($view, array $data = []){
            // require_once Application::$rootPath."/view/".$view.".php";
            $this->view->renderUserView($view, $data);
        }

        public function sendJson($data){
            $tmp = json_encode($data);
            echo $tmp;
        }

        /**
         * @param string $route: include protocol and domain name ie: https://example.com/yoursite
         */
        public function redirect(string $route){
            $site = Application::$protocol."://".Application::$server_name.$route;
            header("Location: ".$site);
            die();
        }
    }