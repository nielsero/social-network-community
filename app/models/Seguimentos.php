<?php
    class Seguimentos {

        public static function findAllFollowersOfUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_usuario WHERE id_usuario_seguido = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findAllFollowingByUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT id_usuario_seguido FROM usuario_usuario WHERE id_usuario_seguidor = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function checkIfUserIsFollower($follower_id, $followed_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_usuario WHERE id_usuario_seguidor = ? AND id_usuario_seguido = ? LIMIT 1', "ii", [$follower_id, $followed_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();
            if(count($data) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public static function add($follower_id, $followed_id) {
            try {
                $db = new Database();
                $stmt = $db->executeQuery('INSERT INTO usuario_usuario(id_usuario_seguidor, id_usuario_seguido) VALUES (?, ?)', "ii", [$follower_id, $followed_id]);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }

        public static function delete($follower_id, $followed_id) {
            try {
                $db = new Database();
                $stmt = $db->executeQuery('DELETE FROM usuario_usuario WHERE id_usuario_seguidor = ? and id_usuario_seguido = ?', "ii", [$follower_id, $followed_id]);
                $db->closeConnection();
                return true;
            } catch(Exception $e) {
                $db->closeConnection();
                return false;
            }
        }
    }