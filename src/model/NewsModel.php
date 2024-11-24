<?php

class NewsModel extends DBModel
{

    public $id;
    public $title;
    public $content;
    public $image;
    public $created_at;

    public function __construct(array $data)
    {
        $this->id = null;
        $this->title = null;
        $this->content = null;
        $this->image = null;
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
        return "news";
    }

    public function attributes(): array
    {
        return ['id', 'title', 'content', 'image', 'created_at'];
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