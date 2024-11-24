<?php
    http_response_code(200);

    require_once __DIR__."/coreAutoLoad.php";

    $env = new DotEnv('./../private/.env');
    $env->load();

    $config = [];
    $config["databases"] = $_ENV["databases"];
    
    $app = new Application($config);

    require_once __DIR__."/../router/homeRouter.php";
    require_once __DIR__."/../router/authRouter.php";
    require_once __DIR__ . "/../router/userRouter.php";
    require_once __DIR__ . "/../router/adminRouter.php";
    
    $app->run();


    
