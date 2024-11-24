<?php

class CartModel extends DBModel
{

    public $id;
    public $username;
    public $product_id;
    public $quantity;
    public $created_at;

    public function __construct(array $data = [])
    {
        $this->id = null;
        $this->username = null;
        $this->product_id = null;
        $this->quantity = null;
        $this->created_at = null;
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
        return "shopping_cart";
    }

    public function attributes(): array
    {
        return ['id', 'username', 'product_id', 'quantity', 'created_at'];
    }

    public function keyAttributes(): array
    {
        return ['id'];
    }

    public function defaultGenteratedAttributes(): array
    {
        return ['created_at'];
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