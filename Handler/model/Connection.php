<?php

    require_once("Helpers.php");

    class SOB_Connection extends Helpers {

        private $serverName = "10.153.239.121";
        private $username = "automation";
        private $password = "automation_APPs2017!";
        private $database = "sob_db";

    //    private $serverName = "localhost";
    //    private $username = "root";
    //    private $password = "";
    //    private $database = "sob_db";

        public $conn;

        public function __construct(){

            //parent::__construct();

            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
            
            mysqli_set_charset($this->conn, 'utf8');
            date_default_timezone_set("Asia/Manila");
        }

        public function ExecuteQuery($query = ""){

            if($query == ""){
                return false;
            }

            if($this->conn->query($query) === TRUE){
                return true;
            }

            return false;
        }

        public function execQuery_getInsertID($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->insert_id;
            }
        }

        public function execQuery_getAffectRows($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->affected_rows;
            }
        }

        public function get_assocArray($result){

            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {

                while ($row = $result->fetch_assoc()) {
                    $tempColumns = array();
                    foreach($row as $col => $value){
                        $tempColumns[$col] = $value;
                    }
                    array_push($data, $tempColumns);
                }
                $result->free();
            }

            return $data;
        }

        public function get_Array($result){
            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {
                while ($row = $result->fetch_assoc()) {
                    foreach($row as $col => $value){
                        $data[$col] = $value;
                    }
                }
                $result->free();
            }

            return $data;
        }
    }

    class ES_Connection extends Helpers {

         private $serverName = "10.153.239.123";
         private $username = "esafety";
         private $password = "Esafety_user2018";
         private $database = "espotsafety_db";

//        private $serverName = "localhost";
//        private $username = "root";
//        private $password = "";
//        private $database = "espotsafety_db";

        public $conn;

        public function __construct(){

            //parent::__construct();

            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
            
            mysqli_set_charset($this->conn, 'utf8');
            date_default_timezone_set("Asia/Manila");
        }

        public function ExecuteQuery($query = ""){

            if($query == ""){
                return false;
            }

            if($this->conn->query($query) === TRUE){
                return true;
            }

            return false;
        }

        public function execQuery_getInsertID($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->insert_id;
            }
        }

        public function execQuery_getAffectRows($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->affected_rows;
            }
        }

        public function get_assocArray($result){

            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {

                while ($row = $result->fetch_assoc()) {
                    $tempColumns = array();
                    foreach($row as $col => $value){
                        $tempColumns[$col] = $value;
                    }
                    array_push($data, $tempColumns);
                }
                $result->free();
            }

            return $data;
        }

        public function get_Array($result){
            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {
                while ($row = $result->fetch_assoc()) {
                    foreach($row as $col => $value){
                        $data[$col] = $value;
                    }
                }
                $result->free();
            }

            return $data;
        }
    }

    class EQ_Connection extends Helpers {

         private $serverName = "10.153.239.123";
         private $username = "root";
         private $password = "ESafety@2018$";
         private $database = "e_quality";

//        private $serverName = "localhost";
//        private $username = "root";
//        private $password = "";
//        private $database = "e_quality";

        public $conn;

        public function __construct(){

            //parent::__construct();

            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
            
            mysqli_set_charset($this->conn, 'utf8');
            date_default_timezone_set("Asia/Manila");
        }

        public function ExecuteQuery($query = ""){

            if($query == ""){
                return false;
            }

            if($this->conn->query($query) === TRUE){
                return true;
            }

            return false;
        }

        public function execQuery_getInsertID($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->insert_id;
            }
        }

        public function execQuery_getAffectRows($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->affected_rows;
            }
        }

        public function get_assocArray($result){

            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {

                while ($row = $result->fetch_assoc()) {
                    $tempColumns = array();
                    foreach($row as $col => $value){
                        $tempColumns[$col] = $value;
                    }
                    array_push($data, $tempColumns);
                }
                $result->free();
            }

            return $data;
        }

        public function get_Array($result){
            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {
                while ($row = $result->fetch_assoc()) {
                    foreach($row as $col => $value){
                        $data[$col] = $value;
                    }
                }
                $result->free();
            }

            return $data;
        }
    }

    class user_Connection extends Helpers {

        private $serverName = "phsm01ws012";
        private $username = "usercheecker";
        private $password = "usercheecker01";
        private $database = "userlookup";

        public $conn;

        public function __construct(){

            //parent::__construct();

            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
            
            mysqli_set_charset($this->conn, 'utf8');
            date_default_timezone_set("Asia/Manila");
        }

        public function ExecuteQuery($query = ""){

            if($query == ""){
                return false;
            }

            if($this->conn->query($query) === TRUE){
                return true;
            }

            return false;
        }

        public function execQuery_getInsertID($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->insert_id;
            }
        }

        public function execQuery_getAffectRows($query){
            if ($this->conn->query($query) === TRUE){
                return $this->conn->affected_rows;
            }
        }

        public function get_assocArray($result){

            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {

                while ($row = $result->fetch_assoc()) {
                    $tempColumns = array();
                    foreach($row as $col => $value){
                        $tempColumns[$col] = $value;
                    }
                    array_push($data, $tempColumns);
                }
                $result->free();
            }

            return $data;
        }

        public function get_Array($result){
            $data = array();

            if (is_object($result) && !empty($result->num_rows)) {
                while ($row = $result->fetch_assoc()) {
                    foreach($row as $col => $value){
                        $data[$col] = $value;
                    }
                }
                $result->free();
            }

            return $data;
        }
    }

?>
