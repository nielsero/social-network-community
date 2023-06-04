<?php
    class Controller {
        
        public $url = "http://localhost/rede_social/public/";  

        public function model($model) {
            require_once "../app/models/" . $model . ".php";
            return new $model();
        }
    
        public function view($view, $data = []) {
            require_once "../app/views/" . $view . ".php";
        }
        
        public function pageNotFound() {
            $this->view("error");
        }
    }