<?php
    $config = [];

    $config["databases"] = [];

    $shop = [];
    $shop["name"] = "shop";
    $shop["type"] = "mysql";
    $shop["host"] = "localhost";
    $shop["username"] = "root";
    $shop["password"] = "Mysqlserver@123";
    array_push($config["databases"], $shop);

    $config["server_name"] = "shop.localtest.me";
    $config["root_path"] = "D:\HCMUT\Lap-trinh-web\BTL\PHP_WEB";
    
    $config = json_encode($config);
    $envFile = fopen("./private/.env", "w") or die("Unable to open .env file.");
    fwrite($envFile, $config);
    fclose($envFile);