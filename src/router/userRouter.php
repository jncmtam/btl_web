<?php
$userController = new UserController();

$app->router->get('/user', $userController, 'showUserPage');

$app->router->get('/profile', $userController, 'showProfilePage');
$app->router->post('/profile', $userController, 'updateProfile');

$app->router->get('/shopping_cart', $userController, 'showShoppingCartPage');
$app->router->post('/shopping_cart', $userController, 'deleteCartItem');

$app->router->get('/contact', $userController, 'showContactPage');
$app->router->post('/contact', $userController, 'saveContact');

$app->router->get('/feedback', $userController, 'showFeedbackPage');
$app->router->get('/fetch_titles', $userController, 'fetchTitles');
$app->router->post('/feedback', $userController, 'saveFeedback');


$app->router->post('/services', $userController, 'addToCart');
