<?php
    class Database {
        private $server = "localhost";
        private $user = "root";
        private $password = "";
        private $db_name = "rede_social";

        private $conn;

        public function __construct() {
            $this->conn = new mysqli($this->server, $this->user, $this->password, $this->db_name);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        private function mountQuery($stmt, $types, $values) {
            if(count($values) > 0) {
                $stmt->bind_param($types, ...$values);
            }
        }

        public function executeQuery($query, $types = "", $values = []) {
            $stmt = $this->conn->prepare($query);
            $this->mountQuery($stmt, $types, $values);
            $stmt->execute();
            return $stmt;
        }

        public function closeConnection() {
            $this->conn->close();
        }
    }