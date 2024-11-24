<?php

class DeleteUserForm extends FormWidget
{

    public $delete_id;

    public function __construct()
    {
        $this->delete_id = null;
        parent::__construct();
    }

    /**
     * Hàm này đặt các điều kiện cho các field được submit
     */
    public function setRules(): void
    {
        $this->rules = [
            'delete_id' => [self::RULE_REQUIRED, self::RULE_NUMBER]
        ];
    }

}