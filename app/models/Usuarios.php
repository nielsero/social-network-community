<?php
    require_once ("../app/util.php");

    class Usuarios {
        
        public static function findById($id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario WHERE usuario_id = ? LIMIT 1', "i", [$id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function findByName($name) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario WHERE usuario_nome = ? LIMIT 1', "s", [$name]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function findByEmail($email) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario WHERE usuario_email = ? LIMIT 1', "s", [$email]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function add($name, $email, $password, $city, $country, $date) {
            if(!checkRegisterUserInputValid($name, $email, $password)) {
                return false;
            }

            try {
                $db = new Database();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $values = [$name, $email, $hashed_password, $city, $country, $date];
                $stmt = $db->executeQuery('INSERT INTO usuario(usuario_nome, usuario_email, usuario_senha, usuario_cidade, usuario_pais, usuario_data_nascimento) VALUES (?, ?, ?, ?, ?, ?)', "ssssss", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }