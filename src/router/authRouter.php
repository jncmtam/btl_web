<?php
    
    $authController = new AuthController();
    
    $app->router->post('/login', $authController, 'login');
    $app->router->post('/register', $authController, 'register');
    $app->router->get('/logout', $authController, 'logout');

    
    // $app->router->get('/auth/register', $authController, 'showRegisterPage');
    // $app->router->get('/auth/logout', $authController, 'logout');