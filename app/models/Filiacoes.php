<?php
    class Filiacoes {

        public static function findAllComunitiesOfUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_comunidade INNER JOIN comunidade ON usuario_comunidade.id_comunidade = comunidade.comunidade_id WHERE usuario_comunidade.id_usuario = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findAllUsersOfCommunityId($community_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_comunidade INNER JOIN usuario ON usuario_comunidade.id_usuario = usuario.usuario_id WHERE id_comunidade = ?', "i", [$community_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findByUserIdAndCommunityId($user_id, $community_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_comunidade WHERE id_usuario = ? and id_comunidade = ? LIMIT 1', "ii", [$user_id, $community_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        }

        public static function delete($user_id, $community_id) {
            try {
                $db = new Database();
                $stmt = $db->executeQuery('DELETE FROM usuario_comunidade WHERE id_usuario = ? and id_comunidade = ?', "ii", [$user_id, $community_id]);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }

        public static function add($user_id, $community_id) {
            try {
                $db = new Database();
                $stmt = $db->executeQuery('INSERT INTO usuario_comunidade(id_usuario, id_comunidade) VALUES (?, ?)', "ii", [$user_id, $community_id]);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }