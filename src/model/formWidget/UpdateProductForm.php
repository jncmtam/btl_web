<?php

class UpdateProductForm extends FormWidget
{
    public $id = null;
    public $name = null;
    public $price = null;
    public $quantity = null;
    public $image = null;

    public function setRules(): void
    {
        $this->rules = [
            'id' => [self::RULE_REQUIRED],
            'name' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'quantity' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'image' => [self::RULE_REQUIRED]
        ];
    }
}