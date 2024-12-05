<?php

require_once __DIR__ . "/controller.php";

class AdminController extends Controller
{

    public function showAdminHomePage(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $userid]]]);

        $res->renderUserView('admin', [
            "user" => $users[0]
        ]);
    }

    public function showManageProductPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // get products
        $products = ProductModel::select();
        $viewData = [
            "products" => $products
        ];
        // case edit
        $body = $req->getBody();
        if(isset($body["edit"])) {
            $productToEdit = ProductModel::selectOne(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $body["edit"]]]]);
            $viewData["productEdit"] = $productToEdit;
        }

        $res->renderUserView('services_admin', $viewData);
    }

    public function updateProduct(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $updateProductForm = new UpdateProductForm();
        $updateProductForm->loadData($body);

        if(!$updateProductForm->validate()){
            $products = ProductModel::select();
            $res->renderUserView('services_admin', [
                "updateProductForm" => $updateProductForm,
                "products" => $products
            ]);
            return;
        }

        $productModel = new ProductModel($body);
        $productModel->update([
            "name" => $updateProductForm->name,
            "price" => $updateProductForm->price,
            "quantity" => $updateProductForm->quantity,
            "image" => $updateProductForm->image
        ]);

        // Get new product list
        $products = ProductModel::select();
        $res->renderUserView('services_admin', [
            "products" => $products,
            "message" => "Update product successfully."
        ]);
    }

    public function deleteProduct(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $deleteProductForm = new DeleteProductForm();
        $deleteProductForm->loadData($body);

        if (!$deleteProductForm->validate()) {
            $products = ProductModel::select();
            $res->renderUserView('services_admin', [
                "deleteProductForm" => $deleteProductForm,
                "products" => $products
            ]);
            return;
        }

        $productModel = new ProductModel([]);
        $productModel->id = $deleteProductForm->delete;
        $productModel->delete();

        // Get new product list
        $products = ProductModel::select();
        $res->renderUserView('services_admin', [
            "products" => $products,
            "message" => "Delete product successfully."
        ]);
    }

    public function addProduct(Request $req, Response $res){
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $addProductForm = new AddProductForm();
        $addProductForm->loadData($body);

        // validate
        if(!$addProductForm->validate()) {
            $products = ProductModel::select();
            $res->renderUserView('services_admin', [
                "addProductForm" => $addProductForm,
                "products" => $products
            ]);
            return;
        }

        // Add product
        $productModel = new ProductModel($body);
        $productModel->save();

        // Get new product list
        $products = ProductModel::select();
        $res->renderUserView('services_admin', [
            "products" => $products,
            "message" => "Product is added."
        ]);
    }

    public function showUserManagementPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // get user
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
        
        $res->renderUserView('usermanagement', [
            "users" => $users
        ]);
    }

    public function addUser(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Read parameters
        $body = $req->getBody();
        $addUserForm = new AddUserForm();
        $addUserForm->loadData($body);

        // Validate
        if(!$addUserForm->validate()) {
            // get user
            $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
            $res->renderUserView('usermanagement', [
                "users" => $users,
                "addUserForm" => $addUserForm
            ]);
            return;
        }

        // Add user
        $userModal = new UserModel($body);
        $userModal->password = password_hash($body["password"], PASSWORD_DEFAULT);
        $userModal->role = "user";
        $userModal->save();

        // get updated user list
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
        $res->renderUserView('usermanagement', [
            "users" => $users,
            "message" => "User added."
        ]);
    }

    public function deleteUser(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Read parameters
        $body = $req->getBody();
        $deleteUserForm = new DeleteUserForm();
        $deleteUserForm->loadData($body);

        // Validate
        if (!$deleteUserForm->validate()) {
            // get user
            $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
            $res->renderUserView('usermanagement', [
                "users" => $users,
                "deleteUserForm" => $deleteUserForm
            ]);
            return;
        }

        // Delete user
        $userModal = new UserModel([]);
        $userModal->id = $deleteUserForm->delete_id;
        $userModal->delete();

        // get updated user list
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
        $res->renderUserView('usermanagement', [
            "users" => $users,
            "message" => "User deleted."
        ]);
    }

    public function editUserPage(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Read parameters
        $body = $req->getBody();

        // Find user
        $foundUser = UserModel::selectOne(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $body["edit_id"]]]]);
        // get user list
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
        $res->renderUserView('usermanagement', [
            "users" => $users,
            "userForEdit" => $foundUser
        ]);
    }

    public function updateUser(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Read parameters
        $body = $req->getBody();
        $updateUserForm = new UpdateUserForm();
        $updateUserForm->loadData($body);

        // Validate
        if (!$updateUserForm->validate()) {
            // get user
            $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
            $res->renderUserView('usermanagement', [
                "users" => $users,
                "updateUserForm" => $updateUserForm
            ]);
            return;
        }

        // update
        $userModel = new UserModel($body);
        $userModel->id = $updateUserForm->user_id;
        $userModel->role = "user";
        $userModel->update([
            "username" => $updateUserForm->username,
            "email" => $updateUserForm->email,
            "phone" => $updateUserForm->phone,
            "password" => password_hash($updateUserForm->password, PASSWORD_DEFAULT)
        ]);

        // get user
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["role", " = ", "user"]]]);
        $res->renderUserView('usermanagement', [
            "users" => $users
        ]);
    }

    public function showManageNewsPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get news
        $news = NewsModel::select();

        $res->renderUserView('news_admin', [
            "newsList" => $news
        ]);
    }

    public function addNews(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get params
        $body = $req->getBody();
        $addNewsForm = new AddNewsForm();
        $addNewsForm->loadData($body);

        // Validate
        if(!$addNewsForm->validate()) {
            // Get news
            $news = NewsModel::select();
            $res->renderUserView('news_admin', [
                "newsList" => $news,
                "addNewsForm" => $addNewsForm
            ]);
        }

        // Add
        $newsModel = new NewsModel($body);
        $newsModel->save();

        // Get news
        $news = NewsModel::select();
        $res->renderUserView('news_admin', [
            "newsList" => $news
        ]);
    }
    
    public function deleteNews(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get params
        $body = $req->getBody();
        if(!isset($body["delete_id"])){
            // Get news
            $news = NewsModel::select();
            $res->renderUserView('news_admin', [
                "newsList" => $news,
                "message" => "Delete ID is required."
            ]);
        }

        // delete
        $newsModel = new NewsModel([]);
        $newsModel->id = $body["delete_id"];
        $newsModel->delete();

        // Get updated news list
        $news = NewsModel::select();
        $res->renderUserView('news_admin', [
            "newsList" => $news
        ]);
    }

    public function updateNews(Request $req, Response $res)
    {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get params
        $body = $req->getBody();
        $updateNewsForm = new UpdateNewsForm();
        $updateNewsForm->loadData($body);
        
        // Validate
        if(!$updateNewsForm->validate()) {
            // Get updated news list
            $news = NewsModel::select();
            $res->renderUserView('news_admin', [
                "newsList" => $news,
                "updateNewsForm" => $updateNewsForm
            ]);
        }

        // Update
        $newsModel = new NewsModel($body);
        $newsModel->update([
            "title" => $body["title"],
            "content" => $body["content"],
            "image" => $body["image"]
        ]);

        // Get updated news list
        $news = NewsModel::select();
        $res->renderUserView('news_admin', [
            "newsList" => $news
        ]);
    }

    public function showManageContactPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // get news
        $contacts = ContactModel::select();
        $res->renderUserView('contact_admin', [
            "contacts" => $contacts
        ]);
    }

    public function deleteContact(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "admin") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get params
        $body = $req->getBody();
        if (!isset($body["delete_id"])) {
            // get contacts
            $contacts = ContactModel::select();
            $res->renderUserView('contact_admin', [
                "contacts" => $contacts,
                "message" => "Delete ID is required."
            ]);
        }

        // delete contact
        $contactModel = new ContactModel([]);
        $contactModel->id = $body["delete_id"];
        $contactModel->delete();

        // get contacts
        $contacts = ContactModel::select();
        $res->renderUserView('contact_admin', [
            "contacts" => $contacts
        ]);
    }
}