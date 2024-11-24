<?php

class FeedbackModel extends DBModel
{

    public $id;
    public $user_id;
    public $type;
    public $reference_id;
    public $comment;
    public $created_at;

    public function __construct(array $data)
    {
        $this->id = null;
        $this->user_id = null;
        $this->type = null;
        $this->reference_id = null;
        $this->comment = null;
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
        return "feedbacks";
    }

    public function attributes(): array
    {
        return ['id', 'user_id', 'type', 'reference_id', 'comment', 'created_at'];
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