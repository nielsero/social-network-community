<?php
    class Artigos {

        public static function findById($id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM artigo WHERE artigo_id = ? LIMIT 1', "i", [$id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function add($title, $description, $text) {
            try {
                $db = new Database();
                $values = [$title, $description, $text];
                $stmt = $db->executeQuery('INSERT INTO artigo(artigo_titulo, artigo_descricao, artigo_texto) VALUES (?, ?, ?)', "sss", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }

        public static function findLatest() {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM artigo ORDER BY artigo_id DESC LIMIT 1');
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