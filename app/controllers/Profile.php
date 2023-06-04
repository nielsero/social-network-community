<?php
    class Profile extends Controller {

        public function index($user_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $usuario_profile = $usuarios::findById($user_id);

            $state = "not_following";

            if(!$usuario_profile) {
                $this->pageNotFound();
            } else {
                $seguimentos = $this->model("Seguimentos");
                $following = $seguimentos::checkIfUserIsFollower($usuario_id, $user_id);

                if($following) {
                    $state = "following";
                }

                $publicacao_artigos = $this->model("PublicacaoArtigos");
                $artigos = $publicacao_artigos::findAllArticlesInCommunitiesByUserId($user_id);

                $publicacao_fotos = $this->model("PublicacaoFotos");
                $fotos = $publicacao_fotos::findAllFotosInCommunitiesByUserId($user_id);

                $publicacao_videos = $this->model("PublicacaoVideos");
                $videos = $publicacao_videos::findAllVideosInCommunitiesByUserId($user_id);

                $comunidades = $this->model("Comunidades");

                $conteudos = [];
                if($artigos) {
                    foreach ($artigos as $artigo) {
                        $comunidade = $comunidades::findById($artigo["id_comunidade"]);
                        $conteudo = ["id" => $artigo["artigo_id"], "titulo" => $artigo["artigo_titulo"], "descricao" => $artigo["artigo_descricao"], "data_publicacao" => $artigo["data_publicacao"], "comunidade" => $comunidade , "tipo" => "artigo"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }

                if($fotos) {
                    foreach ($fotos as $foto) {
                        $comunidade = $comunidades::findById($foto["id_comunidade"]);
                        $conteudo = ["id" => $foto["foto_id"], "titulo" => $foto["foto_titulo"], "descricao" => $foto["foto_descricao"], "data_publicacao" => $foto["data_publicacao"], "comunidade" => $comunidade , "tipo" => "foto"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }

                if($videos) {
                    foreach ($videos as $video) {
                        $comunidade = $comunidades::findById($video["id_comunidade"]);
                        $conteudo = ["id" => $video["video_id"], "titulo" => $video["video_titulo"], "descricao" => $video["video_descricao"], "data_publicacao" => $video["data_publicacao"], "comunidade" => $comunidade , "tipo" => "video"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }
                $this->view("profile/index", ["usuario" => $usuario, "profile" => $usuario_profile, "conteudos" => $conteudos, "state" => $state]);
            }
        }

        public function follow($user_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 

            $seguimentos = $this->model("Seguimentos");
            $command = $seguimentos::add($usuario_id, $user_id);

            header("Location: ".$this->url."profile/index/".$user_id);
            die();
        }

        public function unfollow($user_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 

            $seguimentos = $this->model("Seguimentos");
            $command = $seguimentos::delete($usuario_id, $user_id);

            header("Location: ".$this->url."profile/index/".$user_id);
            die();
        }
    }