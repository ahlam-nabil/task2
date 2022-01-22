<?php
    class db{
        public $server = 'localhost';
        public $dbuser = 'root';
        public $dbpassword = '';
        public $dbname = 'nti_course';
        
        public $connect = null;

        function __construct(){
            $this->connect  = mysqli_connect($this->server,$this->dbuser,$this->dbpassword,$this->dbname);
            if(!$this->connect){
                die("Error: " .mysqli_connect_error());
            }
        }

        function query($sql){
            $operation = mysqli_query($this->connect,$sql);
            return $operation;
        }

        function __destruct(){
            return mysqli_close($this->connect);
        }
    }
?>