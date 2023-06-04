<?php
    class PublicacaoArtigos {
        
        public static function findAllArticlesInCommunitiesByUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_artigo_comunidade INNER JOIN artigo ON usuario_artigo_comunidade.id_artigo = artigo.artigo_id  WHERE id_usuario = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findAllArticlesInCommunity($community_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_artigo_comunidade INNER JOIN artigo ON usuario_artigo_comunidade.id_artigo = artigo.artigo_id WHERE id_comunidade = ?', "i", [$community_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function addArticleToCommunity($user_id, $artigo_id, $community_id) {
            try {
                $db = new Database();
                $values = [$user_id, $artigo_id, $community_id];
                $stmt = $db->executeQuery('INSERT INTO usuario_artigo_comunidade VALUES (?, ?, ?, CURRENT_TIME())', "iii", $values);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }