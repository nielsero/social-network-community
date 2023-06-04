<?php
    require_once("../app/util.php");

    class Login extends Controller {

        public function index($state = "no_error") {
            $this->view("login/index", ["state" => $state]);
        }

        public function submit() {
            // Go back if not sending post data
            if(!isset($_POST["login"])) {
                header("Location: ".$this->url."login");
                die();
            }

            // Get user input
            $email = $_POST["email"];
            $password = $_POST["password"];

            // First check if user exists
            $usuarios = $this->model("Usuarios");
            // if(!checkUserExists()) {

            // }

            $usuario = $usuarios::findByEmail($email);
            if($usuario && verifyPassword($password, $usuario)) {
                $_SESSION["usuario_id"] = $usuario["usuario_id"];
                header("Location: ".$this->url."home");
                die();
            } else {
                header("Location:".$this->url."login/index/error");
                die();
            }
        }
    }