<?php

class AddNewsForm extends FormWidget
{
    public $title = null;
    public $content = null;
    public $image = null;

    public function setRules(): void
    {
        $this->rules = [
            'title' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
            'image' => []
        ];
    }
}