<?php

    class Database{

        public function __construct(array $databases)
        {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            foreach ($databases as $database) {
                if ($database->type == "mysql") {
                    $this->{$database->name} = new Mysqli($database->host, $database->username, $database->password, $database->name);
                }
                if ($database->type == "sqlite") {
                    $this->{$database->name} = new SQLite3(Application::$rootPath.$database->location);
                }
            }

        }

        protected function log($message){
            echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
        }

        public function query($sql, $db_name){
            return $this->{$db_name}->query($sql);
        }

        public function prepare($sql, $db_name){
            return $this->{$db_name}->prepare($sql);
        }

        public function bindValue($statement, $values){
            if (get_class($statement) == "mysqli_stmt"){
                $statement->bind_param(Utilities::$typeList, ...$values);
            } else {
                for ($i=0; $i < count($values); $i++) { 
                    $statement->bindvalue($i+1, $values[$i], Utilities::$typeList[$i]);
                }
            }
            return $statement;
        }

        public function bindParam($statement, $assoc){
            if (get_class($statement) == "mysqli_stmt"){
                $values = array_values($assoc);
                if(count($values) != 0){
                    $statement->bind_param(Utilities::$typeList, ...$values);
                }
            } else {
                foreach ($assoc as $attribute => $value) {
                    $statement->bindParam(":".$attribute, $value, Utilities::$typeList[$attribute]);
                }
            }
            return $statement;
        }

        public function execute($statement){
            if (get_class($statement) == "mysqli_stmt"){
                if(!$statement->execute()){
                    return false;
                } else {
                    return true;
                }
            } else {
                return $statement->execute();                
            }
        }

        public function getResult($statement){
            if (get_class($statement) == "mysqli_stmt"){
                if(!$statement->execute()){
                    return false;
                } else {
                    $result = $statement->get_result();
                    $data = [];
                    while($row = $result->fetch_array()){
                        $data[] = $row;
                    }
                    return $data;
                }
            } else {
                $result = $statement->execute();
                if (!$result) return false;
                $data = [];
                while ($row = $result->fetchArray()) {
                    $data[] = $row;
                }
                return $data;
            }
        }

        public function insert_id($db_name){
            if(get_class($this->{$db_name}) == "mysqli"){
                return $this->{$db_name}->insert_id;
            }
            if(get_class($this->{$db_name}) == "SQLite3"){
                return 0;
            }
        }

    }