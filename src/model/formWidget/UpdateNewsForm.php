<?php

class UpdateNewsForm extends FormWidget
{
    public $id = null;
    public $title = null;
    public $content = null;
    public $image = null;

    public function setRules(): void
    {
        $this->rules = [
            'id' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
            'image' => []
        ];
    }
}