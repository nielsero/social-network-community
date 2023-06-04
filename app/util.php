<?php

    function checkRegisterUserInputValid($name, $email, $password) {
        if(!empty($name) && !empty($email) && !empty($password)) {
            return true;
        }
        return false;
    }

    function verifyPassword($password, $usuario) {
        if(password_verify($password, $usuario["usuario_senha"])) {
            return true;
        } 
        return false;
    }

    function checkUserExists($usuarios_model, $email, $name = "") {
        $usuario = $usuarios_model::findByEmail($email);
        if($usuario) {
            return true;
        }

        // if name is not given
        if($name == "") {
            return false;
        }

        $usuario = $usuarios_model::findByName($name);
        if($usuario) {
            return true;
        }
        return false; // user doesn't exist
    }

    function checkCommunityExists($comunidades_model, $id) {
        $comunidade = $comunidades_model::findById($id);
        if($comunidade) {
            return true;
        }
        return false;
    }

    function checkMembership($filiacoes_model, $user_id, $community_id) {
        $filiacao = $filiacoes_model::findByUserIdAndCommunityId($user_id, $community_id);

        if($filiacao) {
            return true;
        }
        return false;
    }