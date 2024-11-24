<?php
    
    class LoginForm extends FormWidget{

        public $id = null;
        public $username = null;
        public $password = null;
        public $role = null;

        public function setRules(): void
        {
            $this->rules = [
                'username' => [self::RULE_REQUIRED, [self::RULE_EXIST, 'tableName'=>'users', 'db_name'=>"shop"]],
                'password' => [self::RULE_REQUIRED]
            ];
        }

        public function login(){
            $users = UserModel::select(where_clause:["logicOperator"=>"none", "conditions"=>[["username", " = ", $this->username]]]);
            $this->id = $users[0]['id'];
            $this->role = $users[0]['role'];
            if(password_verify($this->password, $users[0]['password'])){
                return true;
            }
            return false;
        }
    }