<?php

class ProductModel extends DBModel
{

    public $id;
    public $name;
    public $price;
    public $quantity;
    public $image;

    public function __construct(array $data)
    {
        $this->id = null;
        $this->name = null;
        $this->price = null;
        $this->quantity = null;
        $this->image = null;
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
        return "products";
    }

    public function attributes(): array
    {
        return ['id', 'name', 'price', 'quantity', 'image'];
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