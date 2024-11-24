<?php
    
    class UserModel extends DBModel{

        public $id;
        public $username;
        public $password;
        public $role;
        public $phone;
        public $email;

        public function __construct(array $data)
        {
            $this->id = null;
            $this->username = null;
            $this->password = null;
            $this->role = null;
            $this->phone = null;
            $this->email = null;
            parent::__construct($data);
        }

        static function db_name(): string
        {
            return "shop";
        }

        static function db_type(): string
        {
            return "Mysqli";
        }

        static function tableName(): string
        {
            return "users";
        }

        public function attributes(): array
        {
            return ['id', 'username', 'password', 'role', 'phone', 'email'];
        }

        public function keyAttributes(): array
        {
            return ['id'];
        }

        public function defaultGenteratedAttributes(): array
        {
            return [];
        }

        public function attributesValue(): array
        {
            $data = [];
            foreach ($this as $attribute => $value) {
                $data[] = $value;
            }
            return $data;
        }

        public function attributesKeyValue(): array
        {
            $data = [];
            foreach ($this as $attribute => $value) {
                $data[$attribute] = $value;
            }
            return $data;
        }
    
    }