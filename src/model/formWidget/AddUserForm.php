<?php

class AddUserForm extends FormWidget
{

    public $username;
    public $password;
    public $email;
    public $phone;

    public function __construct()
    {
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->phone = null;
        parent::__construct();
    }

    /**
     * Hàm này đặt các điều kiện cho các field được submit
     */
    public function setRules(): void
    {
        $this->rules = [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH, 'length' => 10], [self::RULE_UNIQUE, 'tableName' => 'users', 'db_name' => "shop"]],
            'password' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'tableName' => 'users', 'db_name' => 'shop']],
            'phone' => [self::RULE_REQUIRED, self::RULE_NUMBER, [self::RULE_UNIQUE, 'tableName' => 'users', 'db_name' => 'shop']],
        ];
    }

}