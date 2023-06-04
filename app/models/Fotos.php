<?php
    class Fotos {

        public static function findById($id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM foto WHERE foto_id = ? LIMIT 1', "i", [$id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function add($title, $description, $url) {
            try {
                $db = new Database();
                $values = [$title, $description, $url];
                $stmt = $db->executeQuery('INSERT INTO foto(foto_titulo, foto_descricao, foto_url) VALUES (?, ?, ?)', "sss", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }

        public static function findLatest() {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM foto ORDER BY foto_id DESC LIMIT 1');
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }
    }