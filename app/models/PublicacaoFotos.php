<?php
    class PublicacaoFotos {
        
        public static function findAllFotosInCommunitiesByUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_foto_comunidade INNER JOIN foto ON usuario_foto_comunidade.id_foto = foto.foto_id WHERE id_usuario = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findAllFotosInCommunity($community_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_foto_comunidade INNER JOIN foto ON usuario_foto_comunidade.id_foto = foto.foto_id WHERE id_comunidade = ?', "i", [$community_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function addFotoToCommunity($user_id, $foto_id, $community_id) {
            try {
                $db = new Database();
                $values = [$user_id, $foto_id, $community_id];
                $stmt = $db->executeQuery('INSERT INTO usuario_foto_comunidade VALUES (?, ?, ?, CURRENT_TIME())', "iii", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }