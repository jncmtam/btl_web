<?php

class AddProductToCartForm extends FormWidget
{
    public $product_id = null;
    public $quantity = null;

    public function setRules(): void
    {
        $this->rules = [
            'product_id' => [self::RULE_REQUIRED],
            'quantity' => [self::RULE_REQUIRED, self::RULE_NUMBER]
        ];
    }
}