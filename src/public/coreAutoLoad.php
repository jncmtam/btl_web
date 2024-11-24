<?php

    function coreAutoLoad($className){
        $filePath = __DIR__."/../core/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        } 
    }

    function modelAutoLoad($className){
        $filePath = __DIR__."/../model/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        } 
    }

    function formAutoLoad($className){
        $filePath = __DIR__."/../model/formWidget/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        } 
    }

    function controllerAutoLoad($className){
        $filePath = __DIR__."/../controller/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        } 
    }

    function middlewareAutoload($className){
        $filePath = __DIR__."/../core/middlewares/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        } 
    }

    function exceptionAutoload($className){
        $filePath = __DIR__."/../core/exceptions/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        }
    }

    function sqliteModelAutoLoad($className){
        $filePath = __DIR__."/../model/sqliteModel/".$className.".php";
        if(file_exists($filePath)){
            require_once $filePath;
        }
    }

    spl_autoload_register('coreAutoLoad');
    spl_autoload_register('modelAutoLoad');
    spl_autoload_register('controllerAutoLoad');
    spl_autoload_register('middlewareAutoload');
    spl_autoload_register('exceptionAutoload');
    spl_autoload_register('formAutoload');
    spl_autoload_register('sqliteModelAutoLoad');