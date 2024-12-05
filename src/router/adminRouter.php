<?php
$adminController = new AdminController();

$app->router->get('/admin', $adminController, 'showAdminHomePage');

$app->router->get('/services_admin', $adminController, 'showManageProductPage');
$app->router->post('/services_admin', $adminController, 'addProduct');

$app->router->get('/services_admin/edit', $adminController, 'showManageProductPage');
$app->router->post('/services_admin/edit', $adminController, 'updateProduct');
$app->router->get('/services_admin/delete', $adminController, 'deleteProduct');

$app->router->get('/usermanagement', $adminController, 'showUserManagementPage');
$app->router->post('/usermanagement', $adminController, 'addUser');
$app->router->get('/usermanagement_delete', $adminController, 'deleteUser');
$app->router->get('/usermanagement_edit', $adminController, 'editUserPage');
$app->router->post('/usermanagement_edit', $adminController, 'updateUser');

$app->router->get('/newsmanagement', $adminController, 'showManageNewsPage');
$app->router->post('/addNews', $adminController, 'addNews');
$app->router->get('/deleteNews', $adminController, 'deleteNews');
$app->router->post('/updateNews', $adminController, 'updateNews');

$app->router->get('/contact_management', $adminController, 'showManageContactPage');
$app->router->post('/delete_contact', $adminController, 'deleteContact');
