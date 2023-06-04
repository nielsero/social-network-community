<?php
    class Home extends Controller {

        public function index() {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);
            
            $filiacoes = $this->model("Filiacoes");
            $comunidades_afiliadas = $filiacoes::findAllComunitiesOfUserId($usuario_id);

            $publicacao_artigos = $this->model("PublicacaoArtigos");
            $artigos = $publicacao_artigos::findAllArticlesInCommunitiesByUserId($usuario_id);

            $publicacao_fotos = $this->model("PublicacaoFotos");
            $fotos = $publicacao_fotos::findAllFotosInCommunitiesByUserId($usuario_id);

            $publicacao_videos = $this->model("PublicacaoVideos");
            $videos = $publicacao_videos::findAllVideosInCommunitiesByUserId($usuario_id);

            $comunidades = $this->model("Comunidades");

            // Popular conteudos se tiver
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
 
            $this->view("home/index", ["usuario" => $usuario, "comunidades" => $comunidades_afiliadas, "conteudos" => $conteudos]);
        }
    }