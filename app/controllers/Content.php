<?php
    class Content extends Controller {
        
        public function create($community_id, $state="no_error") {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            $comunidades = $this->model("Comunidades");
            $comunidade = $comunidades::findById($community_id);

            $this->view("content/create", ["usuario" => $usuario, "comunidade" => $comunidade, "state" => $state]);
        }

        public function publish() {
            if(!isset($_SESSION["usuario_id"])) { 
                header("Location: ".$this->url."login");
                die();
            }

            $usuario_id = $_SESSION["usuario_id"]; 
            $usuarios = $this->model("Usuarios");
            $usuario = $usuarios::findById($usuario_id);

            if(!isset($_POST["publicar"])) {
                header("Location: ".$this->url);
                die();
            } else {
                $titulo = $_POST["titulo"];
                $descricao = $_POST["descricao"];
                $community_id = $_POST["comunidade_id"];
                $tipo = $_POST["tipo"];

                if($tipo == "artigo") {
                    $artigos = $this->model("Artigos");
                    $publicacaoArtigos = $this->model("PublicacaoArtigos");
                    $texto = $_POST["texto"];

                    $artigos::add($titulo, $descricao, $texto);
                    $latest_artigo = $artigos::findLatest();
                    $latest_artigo_id = $latest_artigo["artigo_id"];

                    $publicacaoArtigos::addArticleToCommunity($usuario_id, $latest_artigo_id, $community_id);

                    header("Location: ".$this->url."content/create/".$community_id."/created");
                    die();
                } else if($tipo == "foto") {
                    $fotos = $this->model("Fotos");
                    $publicacaoFotos = $this->model("PublicacaoFotos");

                    $foto = $_FILES["foto"];
                    $foto_name = $foto["name"];
                    $foto_temp_name = $foto["tmp_name"];
                    $foto_size = $foto["size"];
                    $foto_error = $foto["error"];

                    $foto_ext = explode(".", $foto_name);
                    $foto_actual_ext = strtolower(end($foto_ext));

                    $allowed = ["jpg", "jpeg", "png"];

                    if(in_array($foto_actual_ext, $allowed)) {
                        if($foto_error === 0) {
                            $foto_new_name = uniqid("", true).".".$foto_actual_ext;
                            $foto_destination = "uploads/images/".$foto_new_name;
                            $foto_url = $this->url.$foto_destination;
                            
                            move_uploaded_file($foto_temp_name, $foto_destination);

                            $fotos::add($titulo, $descricao, $foto_url);

                            $latest_foto = $fotos::findLatest();
                            $latest_foto_id = $latest_foto["foto_id"];

                            $publicacaoFotos::addFotoToCommunity($usuario_id, $latest_foto_id, $community_id);

                            header("Location: ".$this->url."content/create/".$community_id."/created");
                            die();
                        } else {
                            header("Location: ".$this->url."content/create/".$community_id."/error");
                            die();
                        }
                    } else {
                        header("Location: ".$this->url."content/create/".$community_id."/error");
                        die();
                    }

                } else {
                    // Videos leave for later, estavam a dar problemas
                    header("Location: ".$this->url."content/create/".$community_id."/error");
                    die();
                }
            }
        }
    }