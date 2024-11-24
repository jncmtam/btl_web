<?php

class DeleteProductForm extends FormWidget
{

    public $delete = null;

    public function setRules(): void
    {
        $this->rules = [
            'delete' => [
                self::RULE_REQUIRED, 
                self::RULE_NUMBER
            ]
        ];
    }
}