<?php

class ContactForm extends FormWidget
{

    public $name = null;
    public $email = null;
    public $message = null;

    public function setRules(): void
    {
        $this->rules = [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'message' => [self::RULE_REQUIRED]
        ];
    }
}