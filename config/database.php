<?php
    // Usage:
    // $DB = DB::Open();
    // $result = $DB->qry(" {SQL Statement} ;");

    abstract class Database_Object
    {
        protected static $DB_Name;
        protected static $DB_Open;
        protected static $DB_Conn;

        protected function __construct($database, $hostname, $hostport, $username, $password)
        {
            self::$DB_Name = $database;
            self::$DB_Conn = mysql_connect($hostname . ":" . $hostport, $username, $password);
            if (!self::$DB_Conn) { die('Critical Stop Error: Database Error<br />' . mysql_error()); }
            mysql_select_db(self::$DB_Name, self::$DB_Conn);
        }

        private function __clone() {}

        public function __destruct()
        {
            mysql_close(self::$DB_Conn);  //<-- commented out due to current shared-link close 'feature'.  If left in, causes a warning that this is not a valid link resource.
        }
    }

    final class DB extends Database_Object
    {
        public static function Open($database = DB_NAME, $hostname = DB_HOST, $hostport = DB_PORT, $username = DB_USER, $password = DB_PASS)
        {
            if (!self::$DB_Open)
            {
                self::$DB_Open = new self($database, $hostname, $hostport, $username, $password);
            }
            else
            {
                self::$DB_Open = null;
                self::$DB_Open = new self($database, $hostname, $hostport, $username, $password);
            }
            return self::$DB_Open;
        }

        public function _qry($sql, $cls, $return_format = 6)
        {
            $query = mysql_query($sql, self::$DB_Conn) OR die(mysql_error()." $sql ");
            $result = Array();
            while ($row = mysql_fetch_object($query, $cls)){
                array_push($result, $row);
            }
            return $result;

// $result = Array();
//             try {
//                 echo "$sql"
//                 $query = mysql_query($sql, self::$DB_Conn); # OR die(mysql_error());
//                 while ($row = mysql_fetch_object($query, $cls)){
//                     array_push($result, $row);
//                 }
//             } catch (Exception $e) {
//                 echo "ERROR IN --> $e. Trying to exec $sql";
//             }
//             return $result;
        }

        public function select($cls, $table, $fields = "*", $condition = NULL, $join = NULL){
            $select = "SELECT $table.$fields FROM $table";
            if ($join != NULL) {
                $select = "$select $join";
            }
            if ($condition != NULL) {
                $select = "$select WHERE $condition";
            }
            return self::_qry($select, $cls);
        }

        public function get($cls, $table, $fields = "*", $condition = NULL){
            $result = self::select($cls, $table, $fields, $condition);
            if (empty($result)){
                throw new Exception($cls.' not found.');
            }
            return $result[0];
        }
        
        public function insert($cls, $table, $data){
            $fields = "(";
            $values = "(";

            foreach($data as $field => $value) {
                if (empty($value)){
                    unset($data[$field]);
                }
            }

            $numItems = count($data);
            $i = 0;
            foreach($data as $field => $value) {
                if (!empty($value)){
                    $fields .= $field;
                    $values .= "'".mysql_real_escape_string(trim($value))."'";
                    if($i+1 < $numItems) {
                        $fields .= ",";
                        $values .= ",";
                    }
                }
                $i++;
            }
            $fields .= ")";
            $values .= ")";

            $insert = "INSERT INTO $table $fields VALUES $values";
            self::_qry($insert, $cls);
            $id = mysql_insert_id();
            return self::get($cls, $table, "*", "id = $id");
        }

        public function update($cls, $table, $data, $condition = NULL){
            $values = "";

            foreach($data as $field => $value) {
                if (empty($value)){
                    unset($data[$field]);
                }
            }

            $numItems = count($data);
            $i = 0;
            foreach($data as $field => $value) {
                if (!empty($value)){
                    $values .= "$field = '".mysql_real_escape_string($value)."'";
                    if($i+1 < $numItems) {
                        $values .= ",";
                    }
                }
                $i++;
            }

            $update = "UPDATE $table SET $values";

            if ($condition != NULL) {
                $update .= " WHERE $condition";
            }
            self::_qry($update, $cls);
            return self::get($cls, $table, "*", "id = ".$data["id"]);
        }
        
        public function delete($cls, $table, $condition = NULL){
            $delete = "DELETE FROM $table";
            if ($condition != NULL) {
                $delete = "$delete WHERE $condition";
            }
            return self::_qry($delete, $cls);
        }
    }
?>