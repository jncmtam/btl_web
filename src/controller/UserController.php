<?php

require_once __DIR__ . "/controller.php";

class UserController extends Controller
{

    public function showUserPage(Request $req, Response $res)
    {
        $role = Application::$session->get("userRole");
        $username = Application::$session->get("username");
        
        // check if user is logged in and has role 'user'
        if(!isset($role) || $role !== "user" || !isset($username)) {
            // response index page
            $res->renderUserView('homeView');
        } else {
            // response user page
            $data = ["username" => $username];
            $res->renderUserView('user', $data);
        }

    }

    public function addToCart(Request $req, Response $res){
        // check session
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if(!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $addProductToCartForm = new AddProductToCartForm();
        $addProductToCartForm->loadData($body);

        if(!$addProductToCartForm->validate()){
            $data = [
                "addProductToCartForm" => $addProductToCartForm,
                "userRole" => $userRole
            ];
            $res->renderUserView('services', $data);
            return;
        }

        $productId = $body["product_id"];
        $quantity = $body["quantity"];
        
        // Is the product exist
        $product = ProductModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $productId]]]);
        if(count($product) == 0) {
            $data = [
                "message" => "Product with ID: " . $productId . " does not exist.",
                "userRole" => $userRole
            ];
            $res->renderUserView('services', $data);
            return;
        }
        // Check if the product is in cart or not
        $product_cart = CartModel::select(where_clause: ["logicOperator" => " AND ", "conditions" => [["product_id", " = ", $productId], ["username", " = ", $username]]]);
        $cartModel = new CartModel($body);
        if(count($product_cart) == 0) {
            // Product is not in cart
            $cartModel->username = $username;
            $result = $cartModel->save();
        } else {
            // Product is in cart
            $currentQuantity = $product_cart[0]["quantity"];
            $newQuantity = $currentQuantity + $quantity;
            $cartModel->loadData($product_cart[0]);
            $result = $cartModel->update(["quantity" => $newQuantity]);
        }

        // Get products from DB
        $products = ProductModel::select();
        $data = ["products" => $products, "userRole" => $userRole];
        $res->renderUserView('services', $data);
    }

    public function showProfilePage(Request $req, Response $res){
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || ($userRole != "user" && $userRole != "admin") ) {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get user data
        $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $userid]]]);
        if(count($users) == 0) {
            throw new UserNotFoundException();
        } else {
            $res->renderUserView('profile', ["user" => $users[0]]);
        }
    }

    public function updateProfile(Request $req, Response $res){
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $updateProfileForm = new UpdateProfileForm();
        $updateProfileForm->loadData($body);

        if(!$updateProfileForm->validate()) {
            $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $userid]]]);
            $res->renderUserView('profile', ["user" => $users[0], "updateProfileForm" => $updateProfileForm]);
        } else {
            $userModel = new UserModel($body);
            $userModel->id = $userid;
            $valuesToUpdate = ["email" => $body["email"], "phone" => $body["phone"]];
            if(isset($body["new_password"]) && $body["new_password"] != "") {
                $valuesToUpdate["password"] = password_hash($body["new_password"], PASSWORD_DEFAULT);
            }
            $userModel->update($valuesToUpdate);
            $users = UserModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $userid]]]);
            $res->renderUserView('profile', ["user" => $users[0], "message" => "Update successfully."]);
        }
    }

    public function showShoppingCartPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        // Get cart data
        $cartData = CartModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["username", " = ", $username]]]);
        // Import product data to each cart item
        $cartData = array_map(function($cartItem) {
            $products = ProductModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $cartItem["product_id"]]]]);
            if(count($products) == 0) {
                throw new ProductNotFoundException($cartItem["product_id"]);
            }
            $cartItem["product"] = $products[0];
            return $cartItem;
        }, $cartData);

        $res->renderUserView('shopping_cart', ["cartData" => $cartData]);
    }

    public function deleteCartItem(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $removeId = $body["remove_product_id"];

        $cartItems = CartModel::select(
            where_clause: [
                "logicOperator" => " AND ", 
                "conditions" => [
                    ["username", " = ", $username], 
                    ["product_id", " = ", $removeId]
                ]
            ]
        );
        if(count($cartItems) != 0){
            // Delete item
            $cartModel = new CartModel();
            $cartModel->id = $cartItems[0]["id"];
            $cartModel->delete();
        }

        // Get updated cart data
        $cartData = CartModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["username", " = ", $username]]]);
        // Import product data to each cart item
        $cartData = array_map(function ($cartItem) {
            $products = ProductModel::select(where_clause: ["logicOperator" => "none", "conditions" => [["id", " = ", $cartItem["product_id"]]]]);
            if (count($products) == 0) {
                throw new ProductNotFoundException($cartItem["product_id"]);
            }
            $cartItem["product"] = $products[0];
            return $cartItem;
        }, $cartData);
        $res->renderUserView('shopping_cart', ["cartData" => $cartData]);
    }

    public function showContactPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $res->renderUserView('contact');
    }

    public function saveContact(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $contactForm = new ContactForm();
        $contactForm->loadData($body);

        if(!$contactForm->validate()) {
            $res->renderUserView('contact', [
                "contactForm" => $contactForm
            ]);
            return;
        }

        // Save
        $contactModel = new ContactModel($body);
        $contactModel->save();

        $res->renderUserView('contact', [
            "message" => "Phản hồi của bạn đã được gửi thành công!"
        ]);
    }

    public function showFeedbackPage(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $res->renderUserView('feedback');
    }

    public function fetchTitles(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $type = $body["type"];
        
        // Determine the correct table and fields based on the feedback type
        if ($type === 'product') {
            // $query = "SELECT id, name AS title FROM products";
            $products = ProductModel::select();
            $products = array_map(function($product) {
                $product["title"] = $product["name"];
                return $product;
            }, $products);

            $res->sendJson($products);
        } elseif ($type === 'news') {
            // $query = "SELECT id, title FROM news";
            $news = NewsModel::select();
            
            $res->sendJson($news);
        }
    }

    public function saveFeedback(Request $req, Response $res) {
        // Check session
        $userid = Application::$session->get("userid");
        $username = Application::$session->get("username");
        $userRole = Application::$session->get("userRole");

        if (!isset($username) || $userRole != "user") {
            $res->renderUserView('/login', ["message" => "Your session is expired. Please login again."]);
            return;
        }

        $body = $req->getBody();
        $feedbackForm = new FeedbackForm();
        $feedbackForm->loadData($body);

        if(!$feedbackForm->validate()){
            $res->renderUserView('feedback', [
                "feedbackForm" => $feedbackForm
            ]);
            return;
        }

        // save feedback
        $feedbackModel = new FeedbackModel($body);
        $feedbackModel->user_id = $userid;
        $feedbackModel->save();

        $res->renderUserView('feedback', [
            "message" => "Your feedback is submitted."
        ]);
    }
}
