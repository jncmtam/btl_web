<?php

class FeedbackForm extends FormWidget
{

    public $type;
    public $reference_id;
    public $comment;

    public function __construct()
    {
        $this->type = null;
        $this->reference_id = null;
        $this->comment = null;
        parent::__construct();
    }

    /**
     * Hàm này đặt các điều kiện cho các field được submit
     */
    public function setRules(): void
    {
        $this->rules = [
            'type' => [self::RULE_REQUIRED],
            'reference_id' => [self::RULE_REQUIRED],
            'comment' => [self::RULE_REQUIRED],
        ];
    }

}