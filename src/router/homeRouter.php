<?php
    $homeController = new HomeController();

    $app->router->get('/', $homeController, 'showHomePage');
    $app->router->get('/home', $homeController, 'showHomePage');
    $app->router->get('/about', $homeController, 'showAboutPage');
    $app->router->get('/news', $homeController, 'showNewsPage');
    $app->router->get('/services', $homeController, 'showServicesPage');
    $app->router->get('/login', $homeController, 'showLoginPage');
    $app->router->get('/register', $homeController, 'showRegisterPage');

