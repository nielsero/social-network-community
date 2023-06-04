<?php
    require_once("../app/util.php");

    class Register extends Controller {
        
        public function index($state = "no_error") {
            $this->view("register/index", ["state" => $state]);
        }

        public function submit() {
            // If not comming from a post request, go back
            if(!isset($_POST["register"])) {
                header("Location: ".$this->url."register");
                die();
            }
            
            // Get user form values
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $city = $_POST["city"];
            $country = $_POST["country"];
            $date = $_POST["date"];

            // Before adding user to database check if he already exists
            $usuarios = $this->model("Usuarios");
            if(checkUserExists($usuarios, $email, $name)) {
                header("Location: ".$this->url."register/index/exists");
                die();
            }

            $command = $usuarios::add($name, $email, $password, $city, $country, $date);
            if($command) {
                header("Location: ".$this->url."login/index/registered");
                die();
            } else {
                header("Location: ".$this->url."register/index/error");
                die();
            }
        }
    }