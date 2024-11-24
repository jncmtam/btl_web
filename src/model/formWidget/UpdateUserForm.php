<?php

class UpdateUserForm extends FormWidget
{
    public $user_id;
    public $username;
    public $email;
    public $phone;
    public $password;

    public function __construct()
    {
        $this->user_id = null;
        $this->username = null;
        $this->email = null;
        $this->phone = null;
        $this->password = null;
        parent::__construct();
    }

    /**
     * Hàm này đặt các điều kiện cho các field được submit
     */
    public function setRules(): void
    {
        $this->rules = [
            'user_id' => [self::RULE_REQUIRED],
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_NOT_EXIST, 'tableName' => 'users', 'db_name' => "shop"]],
            'phone' => [self::RULE_REQUIRED, self::RULE_NUMBER, [self::RULE_MIN_LENGTH, 'length' => 15], [self::RULE_NOT_EXIST, 'tableName' => 'users', 'db_name' => "shop"]],
            'password' => [self::RULE_REQUIRED],
        ];
    }

}