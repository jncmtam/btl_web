<?php

    abstract class FormWidget{

        public const RULE_REQUIRED = 'required';
        public const RULE_EMAIL = 'email';
        public const RULE_MIN_LENGTH = 'minLength';
        public const RULE_UNIQUE = 'unique';
        public const RULE_MATCH = 'match';
        public const RULE_EXIST = 'exist';
        public const RULE_NUMBER = 'number';
        public const RULE_NOT_EXIST = 'not_exist';

        public $rules = [];
        public $errors = [];
        public $token = null;
        public $errorMessesges = [
            self::RULE_REQUIRED => "This field is required.",
            self::RULE_EMAIL => "This field must be a valid email address.",
            self::RULE_MATCH => "This field must be the same as __param__.",
            self::RULE_MIN_LENGTH => "This field must have at least __param__ characters.",
            self::RULE_UNIQUE => "This value has been existing in the system.",
            self::RULE_EXIST => "This __param__ does not exist in the system.",
            self::RULE_NUMBER => "This filed must contain number only.",
            self::RULE_NOT_EXIST => "This value is already used."
        ];

        public function __construct()
        {
            $this->setRules();
        }
        
        /**
         * Save data from Post request to property
         * input: @array $data with key and value
         */
        public function loadData(array $data) : void{
            // print_r("Loading data...");
            foreach ($data as $key => $value) {
                if(property_exists($this, $key)){
                    $this->{$key} = $value;
                }
            }
        }

        /**
         * Set rule for each attributes in model
         */
        abstract public function setRules(): void;

        /**
         * Check each attributes is valid with its rules or not
         */
        public function validate(){
            // print_r("Validating data...");
            foreach ($this->rules as $attribute => $rules) {
                $value = $this->{$attribute};
                foreach ($rules as $rule ) {
                    $ruleName = (is_string($rule)) ? $rule : $rule[0];

                    if($ruleName == self::RULE_REQUIRED && (is_null($value) || $value === "")){
                        $this->addError($attribute, self::RULE_REQUIRED);
                    }
                    if($ruleName == self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $this->addError($attribute, self::RULE_EMAIL);
                    }
                    if($ruleName == self::RULE_MATCH && $value != $this->{$rule["match"]}){
                        $this->addError($attribute, self::RULE_MATCH, $rule["match"]);
                    }
                    if($ruleName == self::RULE_MIN_LENGTH && strlen($value) > $rule['length']){
                        $this->addError($attribute, self::RULE_MIN_LENGTH, (string)$rule['length']);
                    }
                    if ($ruleName == self::RULE_NUMBER && !ctype_digit($value)) {
                        $this->addError($attribute, self::RULE_NUMBER);
                    }
                    if ($ruleName == self::RULE_UNIQUE) {
                        $tableName = $rule["tableName"];
                        $db_name = $rule["db_name"];
                        $sql = Utilities::makeSelectStatement(table_name:$tableName, where_clause:["logicOperator"=>" AND ", "conditions"=>[[$attribute, " = ", $value]]]);
                        $statement = Application::$database->prepare($sql, $db_name);
                        $statement = Application::$database->bindParam($statement, [$attribute=>$value]);
                        $data = Application::$database->getResult($statement);
                        if(count($data) != 0){
                            $this->addError($attribute, self::RULE_UNIQUE);
                        }
                    }

                    if ($ruleName == self::RULE_EXIST){
                        $tableName = $rule["tableName"];
                        $db_name = $rule["db_name"];
                        $sql = Utilities::makeSelectStatement(table_name:$tableName, where_clause:["logicOperator"=>" AND ", "conditions"=>[[$attribute, " = ", $value]]]);
                        $statement = Application::$database->prepare($sql, $db_name);
                        $statement = Application::$database->bindParam($statement, [$attribute=>$value]);
                        $data = Application::$database->getResult($statement);
                        if (count($data) == 0) {
                            $this->addError($attribute, self::RULE_EXIST, $attribute);
                        }
                    }

                    if ($ruleName == self::RULE_NOT_EXIST) {
                        $tableName = $rule["tableName"];
                        $db_name = $rule["db_name"];
                        $sql = Utilities::makeSelectStatement(table_name: $tableName, where_clause: ["logicOperator" => "none", "conditions" => [[$attribute, " = ", $value]]]);
                        $statement = Application::$database->prepare($sql, $db_name);
                        $statement = Application::$database->bindParam($statement, [$attribute => $value]);
                        $data = Application::$database->getResult($statement);
                        if (count($data) > 1) {
                            $this->addError($attribute, self::RULE_NOT_EXIST);
                        }
                    }
                }
            }
            return empty($this->errors);
        }

        public function addError($attribute, $rule, $param = null){
            $message = $this->errorMessesges[$rule];
            if(!is_null($param)){
                $message =  str_replace("__param__", $param, $message);
            }
            if(!isset($this->errors[$attribute])){
                $this->errors[$attribute] = $message;
            }
        }

        protected function isDuplicateSubmission(){
            if(is_null($this->token)){
                return false;
            }
            // if there is a form token
            if($formToken = Application::$session->get('formToken')){
                return $formToken != $this->token;
            } else {
                // set a token
                Application::$session->set('formToken', $this->token);
                return true;
            }
        }

        public function __toString() 
        {
            return '';
        }
    }