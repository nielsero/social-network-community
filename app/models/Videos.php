<?php
    class Videos {

        public static function findById($id) {
            $db = new Database();
            $stmt = $db->executeQuery('SELECT * FROM video WHERE video_id = ? LIMIT 1', "i", [$id]);
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