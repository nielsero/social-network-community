<?php
    require_once("../app/util.php");

    class Community extends Controller {

        public function index() {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }
    
            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $comunidades = $this->model("Comunidades");
            $comunidades_list = $comunidades::findAll();

            $this->view("community/index", ["usuario" => $usuario, "comunidades" => $comunidades_list]);
        }

        public function show($community_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $comunidades = $this->model("Comunidades");
            $comunidade = $comunidades::findById($community_id);

            if(!$comunidade) {
                $this->pageNotFound();
            } else {
                $criador = $usuarios::findById($comunidade["id_usuario"]);
                $filiacoes = $this->model("Filiacoes");
                $membros = $filiacoes::findAllUsersOfCommunityId($community_id);

                $publicacao_artigos = $this->model("PublicacaoArtigos");
                $artigos = $publicacao_artigos::findAllArticlesInCommunity($community_id);

                $publicacao_fotos = $this->model("PublicacaoFotos");
                $fotos = $publicacao_fotos::findAllFotosInCommunity($community_id);

                $publicacao_videos = $this->model("PublicacaoVideos");
                $videos = $publicacao_videos::findAllVideosInCommunity($community_id);

                // Popular conteudos
                $conteudos = [];
                if($artigos) {
                    foreach ($artigos as $artigo) {
                        $publicador = $usuarios::findById($artigo["id_usuario"]);
                        $conteudo = ["id" => $artigo["artigo_id"], "titulo" => $artigo["artigo_titulo"], "descricao" => $artigo["artigo_descricao"], "data_publicacao" => $artigo["data_publicacao"], "publicador" => $publicador, "tipo" => "artigo"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }

                if($fotos) {
                    foreach ($fotos as $foto) {
                        $publicador = $usuarios::findById($foto["id_usuario"]);
                        $conteudo = ["id" => $foto["foto_id"], "titulo" => $foto["foto_titulo"], "descricao" => $foto["foto_descricao"], "data_publicacao" => $foto["data_publicacao"], "publicador" => $publicador, "tipo" => "foto"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }

                if($videos) {
                    foreach ($videos as $video) {
                        $publicador = $usuarios::findById($video["id_usuario"]);
                        $conteudo = ["id" => $video["video_id"], "titulo" => $video["video_titulo"], "descricao" => $video["video_descricao"], "data_publicacao" => $video["data_publicacao"], "publicador" => $publicador, "tipo" => "video"];
                        $conteudos = [...$conteudos, $conteudo];
                    }
                }

                if(checkMembership($filiacoes, $usuario_id, $community_id)) {
                    $state = "member";
                } else {
                    $state = "not_member";
                }

                $this->view("community/show", ["usuario" => $usuario, "comunidade" => $comunidade, "membros" => $membros, "criador" => $criador, "conteudos" => $conteudos, "state" => $state]);
            }
        }

        public function create() {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            if(!isset($_POST["create"])) {
                $this->view("community/create", ["usuario" => $usuario, "state" => "no_error"]);
            } else {
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];
                
                $comunidades = $this->model("Comunidades");
                $command = $comunidades::add($nome, $descricao, $usuario_id);

                if($command) {
                    $this->view("community/create", ["usuario" => $usuario, "state" => "created"]);
                } else {
                    $this->view("community/create", ["usuario" => $usuario, "state" => "error"]);
                }
            }
        }

        public function leave($community_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $filiacoes = $this->model("Filiacoes");

            if(checkMembership($filiacoes, $usuario_id, $community_id)) {
                $command = $filiacoes::delete($usuario_id, $community_id); 
            }
            header("Location: ".$this->url."community/show/".$community_id);
            die();
        }

        public function enter($community_id) {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $filiacoes = $this->model("Filiacoes");

            if(!checkMembership($filiacoes, $usuario_id, $community_id)) {
                $command = $filiacoes::add($usuario_id, $community_id);
            }
            header("Location: ".$this->url."community/show/".$community_id);
            die();
        }
    }