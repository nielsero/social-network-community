<?php
    class Comunidades {

        public static function findById($id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM comunidade WHERE comunidade_id = ? LIMIT 1', "i", [$id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function findAll() {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM comunidade');
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function add($name, $description, $user_id) {
            try {
                $db = new Database();
                $values = [$name, $description, $user_id];
                $stmt = $db->executeQuery('INSERT INTO comunidade(comunidade_nome, comunidade_descricao, id_usuario, data_criacao) VALUES (?, ?, ?, CURRENT_DATE())', "ssi", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }