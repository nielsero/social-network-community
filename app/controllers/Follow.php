<?php
    class Follow extends Controller {
        
        public function index() {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }
    
            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $seguimentos = $this->model("Seguimentos");
            $seguidores = $seguimentos::findAllFollowersOfUserId($usuario_id);
            $seguidos = $seguimentos::findAllFollowingByUserId($usuario_id);

            $seguidores_list = [];
            if($seguidores) {
                foreach($seguidores as $seguidor) {
                    $usuario_seguidor = $usuarios::findById($seguidor["id_usuario_seguidor"]);
                    $seguidores_list = [...$seguidores_list, $usuario_seguidor];
                }
            }

            $seguidos_list = [];
            if($seguidos) {
                foreach($seguidos as $seguido) {
                    $usuario_seguido = $usuarios::findById($seguido["id_usuario_seguido"]);
                    $seguidos_list = [...$seguidos_list, $usuario_seguido];
                }
            }

            $this->view("follow/index", ["usuario" => $usuario, "seguidores" => $seguidores_list, "seguidos" => $seguidos_list]);
        }
    }