<?php
    
    class Application{
        
        public Router $router;
        public static $server_name;
        public static $protocol = "http";
        public static $rootPath;
        public static Database $database;
        public static Session $session;
        public static $user = null;
        public static $userRole = "";
        public static $baseUrl = "";

        function __construct($config){
            $this->router = new Router();
            static::$database = new Database($config["databases"]);
            static::$session = new Session();
            static::$server_name = $_ENV["server_name"];
            static::$rootPath = $_ENV["root_path"];
            static::$baseUrl = static::$protocol."://".static::$server_name;
        }

        /**
         * return protocol and domain name
         */
        public static function siteURL(){
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'];
            return $protocol.$domainName;
        }
        
        public static function isLogined(){
            if(static::$session->get('user') && !is_null(static::$user)){
                return true;
            }
            return false;
        }

        public function run(){
            try {
                $this->router->resolve();
            } catch (Exception $exception) {
                $this->router->setStatusCode($exception->getCode());
                $this->router->render('errors/error',[
                    'exception'=>$exception
                ]);
            }
        }

        /**
         * @param $id: user id
         */
        public static function login($id, $username, $role){
            self::$session->set('userid', $id);
            self::$session->set('username', $username);
            self::$session->set('userRole', $role);
        }

        public static function logout(){
            self::$session->remove('userid');
            self::$session->remove('username');
            self::$session->remove('userRole');
            self::$session->destroy();
        }
        
    }