<?php
    
    class Utilities{
        
        public static $typeList;

        public static function filterVietnameseAccent($str){
            $tl = Transliterator::create('Latin-ASCII;');
            return $tl->transliterate($str);
        }

        public static function processToSearch($str){
            if (gettype($str) != "string") $str = strval($str);
            $str = trim($str);
            $pattern = "/\s+/";
            $str = preg_replace($pattern, " ", $str);
            $str = Utilities::filterVietnameseAccent($str);
            $str = strtoupper($str);
            return $str;
        }

        /**
         * @param array $where_clause = [
         *      "logicOperator" => "AND | OR | none",
         *      "conditions" => [
         *          ["col_name", "operator", value],
         *          ["col_name", "operator", value]
         *      ]
         * ]
         */
        public static function makeSelectStatement(
                bool $distinct = false, 
                array $column_list = [], 
                string $table_name = "", 
                array $where_clause = [], 
                array $groupby_clause = [], 
                array $having_clause = [], 
                array $orderby_clause = [],
                int $limit = 0,
                int $offset = 0,
                string $db_type = "Mysqli")
        {
            $sql = "SELECT distinct column_list FROM table_name where_clause groupby_clause having_clause orderby_clause limit offset";
            static::$typeList = "";
            if($db_type == "SQLite3"){
                static::$typeList = [];
            }
            return str_replace(
                ["distinct", "column_list", "table_name", "where_clause", "groupby_clause", "having_clause", "orderby_clause", "limit", "offset"],
                [
                    static::distinct($distinct), 
                    static::makeColumnList($column_list),
                    $table_name,
                    static::makeWhereClause($where_clause, $db_type),
                    static::makeGroubyClause($groupby_clause),
                    static::makeHavingClause($having_clause, $db_type),
                    static::makeOrderByClause($orderby_clause),
                    static::limitClause($limit),
                    static::offsetClause($offset)
                ],
                $sql
            );
        }

        public static function distinct($distinct){
            return ($distinct) ? "DISTINCT" : "";
        }

        public static function makeColumnList($column_list){
            if (count($column_list) == 0) return "*";
            $column_list = array_map(function($col_name){
                return "`".$col_name."`";
            }, $column_list);

            return implode(",", $column_list);
        }

        /**
         * @param array $where_clause = [
         *      "logicOperator" => "AND | OR | none",
         *      "conditions" => [
         *          ["col_name", "operator", value],
         *          ["col_name", "operator", value]
         *      ]
         * ]
         */
        public static function makeWhereClause(array $where_clause, string $db_type){
            if (count($where_clause) == 0) return "";
            $conditions = $where_clause["conditions"];
            $conditions = array_map(function($condition) use ($db_type) {
                if ($db_type === "SQLite3") {
                    static::$typeList[$condition[0]] = static::getTypeChar($condition[2], $db_type);
                    return $condition[0]." ".$condition[1]." :".strval($condition[0]);
                } else {
                    static::$typeList .= static::getTypeChar($condition[2], $db_type);
                    return $condition[0]." ".$condition[1]." ?";
                }
            }, $conditions);
            return "WHERE ".implode($where_clause["logicOperator"], $conditions);
        }

        public static function makeGroubyClause(array $groupby_clause){
            if (count($groupby_clause) == 0) return "";
            return "GROUP BY ".implode(",", $groupby_clause);
        }

        /**
         * $having_clause = [
         *      "logicOperator" => "AND | OR",
         *      "conditions" => [
         *          ["col_name", "operator", value],
         *          ["col_name", "operator", value]
         *      ]
         * ]
         */
        public static function makeHavingClause(array $having_clause, $db_type){
            if(count($having_clause) == 0) return "";
            $conditions = $having_clause["conditions"];
            $conditions = array_map(function($condition) use ($db_type){
                if ($db_type === "SQLite3") {
                    static::$typeList[$condition[0]] = static::getTypeChar($condition[2], $db_type);
                    return $condition[0]." ".$condition[1]." :".strval($condition[0]);
                } else {
                    static::$typeList .= static::getTypeChar($condition[2], $db_type);
                    return $condition[0]." ".$condition[1]." ?";
                }
            }, $conditions);
            return "HAVING ".implode(",", $conditions);
        }

        /**
         * $orderby_clause = [
         *      "type" => "ASD | DESC",
         *      "columns" => ["colname", "colname"]
         * ]
         */
        public static function makeOrderByClause(array $orderby_clause){
            if (count($orderby_clause) == 0) return "";
            $columns = implode(",", $orderby_clause["columns"]);
            return "ORDER BY ".$columns." ".$orderby_clause["type"];
        }

        public static function limitClause(int $limit){
            if ($limit == 0) return "";
            return "LIMIT ".strval($limit);
        }

        public static function offsetClause(int $offset){
            if($offset == 0) return "";
            return "OFFSET ".strval($offset);
        }

        protected static function getTypeChar($value, $db_type){
            $type = gettype($value);
            if($type == "string"){
                return ($db_type === "SQLite3") ? SQLITE3_TEXT : "s";
            }
            if($type == "integer"){
                return ($db_type === "SQLite3") ? SQLITE3_INTEGER : "i";
            }
            if($type == "double"){
                return ($db_type === "SQLite3") ? SQLITE3_FLOAT : "d";
            }
            return ($db_type === "SQLite3") ? SQLITE3_BLOB : "b";
        }

        public static function makeInsertStatment($tableName, array $columns = [], array $values, string $db_type){
            static::$typeList = "";
            if($db_type == "SQLite3"){
                static::$typeList = [];
            }
            $sql = "INSERT INTO tableName cols VALUES ";
            $sql = str_replace("tableName", $tableName, $sql);
            $cols = (static::makeColumnList($columns) == "*") ? "" : static::makeColumnList($columns);
            $cols = "(".$cols.")";
            $cols = str_replace("`", "", $cols);
            $sql = str_replace("cols", $cols, $sql);
            return $sql . static::makeValuesList($values, $db_type);
        }

        public static function makeUpdateStatement($tableName, array $whereClause, $valuesForUpdate, string $db_type){
            static::$typeList = "";
            if ($db_type == "SQLite3") {
                static::$typeList = [];
            }
            $assignments = static::makeAssignment($valuesForUpdate, $db_type);
            $whereClause = static::makeWhereClause($whereClause, $db_type);
            $sql = "UPDATE {$tableName} SET {$assignments} {$whereClause}";
            
            return $sql;
        }

        public static function makeDeleteStatement($table_name, $where_clause, $db_type){
            $sql = "DELETE FROM tableName where_clause" ;
            $sql = str_replace("tableName", $table_name, $sql);
            if($db_type === "SQLite3") {
                static::$typeList = [];
            } else {
                static::$typeList = "";
            }
            $sql = str_replace("where_clause", static::makeWhereClause($where_clause, $db_type), $sql);
            return $sql;
        }
        
        /**
         * @param $values = [
         *      ["values", "values"],
         *      ...
         * ]
         */
        protected static function makeValuesList(array $values, $db_type){
            $values = array_map(function($row) use ($db_type){
                $row = array_map(function($value) use ($db_type) {
                    if ($db_type === "SQLite3") {
                        static::$typeList[] = static::getTypeChar($value, $db_type);
                        return " ? ";
                    } else {
                        static::$typeList .= static::getTypeChar($value, $db_type);
                        return " ? ";
                    }
                }, $row);
                return "(".implode(",", $row).")";
            }, $values);
            return implode(",", $values);
        }

        /**
         * Summary of makeAssignment
         * @param array $values ["colname" => value, ...]
         * @param array $keyAttributes ["value", ...]
         * @return string
         */
        protected static function makeAssignment(array $valuesForUpdate, string $db_type) {
            $values = [];
            foreach ($valuesForUpdate as $key => $value) {
                if ($db_type === "SQLite3") {
                    static::$typeList[] = static::getTypeChar($value, $db_type);
                    $values[] = " {$key} = ? ";
                } else {
                    static::$typeList .= static::getTypeChar($value, $db_type);
                    $values[] = " {$key} = ? ";
                }
            }
            return implode(",", $values);
        }
    }