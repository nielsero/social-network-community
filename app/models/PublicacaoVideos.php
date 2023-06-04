<?php
    class PublicacaoVideos {
        
        public static function findAllVideosInCommunitiesByUserId($user_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_video_comunidade INNER JOIN video ON usuario_video_comunidade.id_video = video.video_id WHERE id_usuario = ?', "i", [$user_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }

        public static function findAllVideosInCommunity($community_id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM usuario_video_comunidade INNER JOIN video ON usuario_video_comunidade.id_video = video.video_id WHERE id_comunidade = ?', "i", [$community_id]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $db->closeConnection();

            if(count($data) > 0) {
                return $data;
            } else {
                return null;
            }
        }
    }