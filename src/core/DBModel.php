<?php
    abstract class DBModel{
        
        abstract static function db_name(): string;
        abstract static function db_type(): string;
        abstract static function tableName(): string;
        abstract public function attributes(): array;
        abstract public function attributesValue(): array;
        abstract public function attributesKeyValue(): array;
        abstract public function keyAttributes(): array;
        abstract public function defaultGenteratedAttributes(): array;

        public function __construct(array $data)
        {
            $this->loadData($data);
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

        public function save(){
            // Exclude auto generated column
            $attributeKeyValue = $this->attributesKeyValue();
            $exclusion = array_merge($this->defaultGenteratedAttributes(), $this->keyAttributes());
            foreach ($attributeKeyValue as $key => $value) {
                if(in_array($key, $exclusion)) {
                    unset($attributeKeyValue[$key]);
                }
            }
            // query
            $sql = Utilities::makeInsertStatment(static::tableName(), array_keys($attributeKeyValue), [array_values($attributeKeyValue)], static::db_type());
            $statement = Application::$database->prepare($sql, static::db_name());
            $statement = Application::$database->bindValue($statement, array_values($attributeKeyValue));
            return $statement->execute();
        }

        public function update(array $valuesToUpdate) {
            
            // Search condition
            $conditions = [];
            $primaryKeys = $this->keyAttributes();
            $values = $this->attributesKeyValue();
            foreach ($primaryKeys as $key) {
                $conditions[] = [$key, " = ", $values[$key]];
            }

            // SQL script
            $sql = Utilities::makeUpdateStatement(
                static::tableName(), 
                ["logicOperator" => "none", "conditions" => $conditions], 
                $valuesToUpdate, 
                static::db_type()
            );
            
            // Values to bind
            foreach ($conditions as $condition) {
                $valuesToUpdate[] = $condition[2];
            }
            $statement = Application::$database->prepare($sql, static::db_name());
            $statement = Application::$database->bindValue($statement, array_values($valuesToUpdate));
            return $statement->execute();
        }

        public function delete()
        {
            // Search condition
            $conditions = [];
            $primaryKeys = $this->keyAttributes();
            $values = $this->attributesKeyValue();
            foreach ($primaryKeys as $key) {
                $conditions[] = [$key, " = ", $values[$key]];
            }
            $where_clause = ["logicOperator" => "none", "conditions" => $conditions];

            // Query
            $sql = Utilities::makeDeleteStatement(static::tableName(), $where_clause, static::db_type());
            $statement = Application::$database->prepare($sql, static::db_name());
            $values = [];
            if (isset($where_clause["conditions"])) {
                foreach ($where_clause["conditions"] as $condition) {
                    $values[] = $condition[2];
                }
            }
            $statement = Application::$database->bindParam($statement, $values);
            return Application::$database->execute($statement);
        }

        public static function select(
            bool $distinct = false, 
            array $column_list = [], 
            array $where_clause = [], 
            array $groupby_clause = [], 
            array $having_clause = [], 
            array $orderby_clause = [],
            int $limit = 0,
            int $offset = 0,
            string $db_type = "Mysqli")
        {
            $sql =  Utilities::makeSelectStatement($distinct, $column_list, static::tableName(), $where_clause, $groupby_clause, $having_clause, $orderby_clause, $limit, $offset, $db_type);
            $statement = Application::$database->prepare($sql, static::db_name());
            $values = [];
            if(isset($where_clause["conditions"])){
                foreach ($where_clause["conditions"] as $condition ) {
                    $values[] = $condition[2];
                }
            }
            $statement = Application::$database->bindParam($statement, $values);
            return Application::$database->getResult($statement);
        }

        public static function selectOne(
            bool $distinct = false, 
            array $column_list = [], 
            array $where_clause = [], 
            array $groupby_clause = [], 
            array $having_clause = [], 
            array $orderby_clause = [],
            int $limit = 0,
            int $offset = 0,
            string $db_type = "Mysqli")
        {
            $sql =  Utilities::makeSelectStatement($distinct, $column_list, static::tableName(), $where_clause, $groupby_clause, $having_clause, $orderby_clause, $limit, $offset, $db_type);
            $statement = Application::$database->prepare($sql, static::db_name());
            $values = [];
            foreach ($where_clause["conditions"] as $condition ) {
                $values[] = $condition[2];
            }
            $statement = Application::$database->bindParam($statement, $values);
            $data = Application::$database->getResult($statement);
            return $data[0];
        }
    }