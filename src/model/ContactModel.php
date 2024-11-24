<?php

class ContactModel extends DBModel
{

    public $id;
    public $name;
    public $email;
    public $message;
    public $created_at;

    public function __construct(array $data)
    {
        $this->id = null;
        $this->name = null;
        $this->email = null;
        $this->message = null;
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
        return "contacts";
    }

    public function attributes(): array
    {
        return ['id', 'name', 'email', 'message', 'created_at'];
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