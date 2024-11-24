<?php

class UpdateProfileForm extends FormWidget
{

    public $email;
    public $phone;
    public $new_password;
    public $confirm_password;

    public function __construct()
    {
        $this->email = null;
        $this->phone = null;
        $this->new_password = null;
        $this->confirm_password = null;
        parent::__construct();
    }

    /**
     * Hàm này đặt các điều kiện cho các field được submit
     */
    public function setRules(): void
    {
        $this->rules = [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_NOT_EXIST, 'tableName' => 'users', 'db_name' => "shop"]],
            'phone' => [self::RULE_REQUIRED, self::RULE_NUMBER, [self::RULE_MIN_LENGTH, 'length' => 15], [self::RULE_NOT_EXIST, 'tableName' => 'users', 'db_name' => "shop"]],
            'new_password' => [],
            'confirm_password' => [[self::RULE_MATCH, "match" => "new_password"]],
        ];
    }

}