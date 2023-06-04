<?php
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "follow";
    $profile = $data["profile"];
    $title = $profile["usuario_nome"];
    $conteudos = $data["conteudos"];
    $state = $data["state"];

    $current_profile_picture = $profile["usuario_foto_url"];

    include("../app/views/header.php");

    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }

    if(!$current_profile_picture) {
        $current_profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="profile">
    <?php include("../app/views/nav.php") ?>

    <section class="profile-section">
        <div class="profile-contents-section">
            <h1 class="profile-contents-title">Conteúdos</h1>
            <?php
                if(count($conteudos) == 0) {
                    echo "<p class='profile-contents-empty-text'>Nenhum conteúdo</p>";
                }

                else {
                    echo "<div class='profile-contents'>";
                    foreach ($conteudos as $conteudo) {
                        $tipo = $conteudo["tipo"];
                        echo "<div class='profile-content' data-tipo='".$tipo." data-id='".$conteudo["id"]."''>";
                        $comunidade = $conteudo["comunidade"];
                        if($tipo == "artigo") {
                            echo "<div class='profile-content-type'><i class='bx bxs-message-alt-detail'></i> Artigo em <span class='profile-content-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        } else if($tipo == "foto") {
                            echo "<div class='profile-content-type'><i class='bx bxs-image'></i> Foto em <span class='profile-content-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        } else if($tipo == "video") {
                            echo "<div class='profile-content-type'><i class='bx bxs-video'></i> Video em <span class='profile-content-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        }
                        echo "<h2 class='profile-content-title'>".$conteudo["titulo"]."</h2>";
                        echo "<p class='profile-content-description'>".$conteudo["descricao"]."</p>";
                        echo "<p class='profile-content-date-publicated'>".$conteudo["data_publicacao"]."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>

        <div class="profile-info">
            <h2 class="profile-name"><?= $profile["usuario_nome"] ?></h2>
            <div class="profile-image-container"><img class="profile-image" src="<?= $current_profile_picture ?>"></div>
            <?php 
                if($profile["usuario_cidade"]) {
                    echo "<p class='profile-city'>Cidade: ".$profile["usuario_cidade"]."</p>";
                }
                if($profile["usuario_pais"]) {
                    echo "<p class='profile-country'>Pais: ".$profile["usuario_pais"]."</p>";
                }

                if($usuario["usuario_id"] != $profile["usuario_id"]) {
                    if($state == "following") {
                        echo "<button class='profile-unfollow-button' data-id='".$profile["usuario_id"]."'>Deixar de seguir</button>";
                    } else {
                        echo "<button class='profile-follow-button' data-id='".$profile["usuario_id"]."'>Seguir</button>";
                    }
                }
            ?>
        </div>
    </section>
</main>

<script>
    const followButton = document.querySelector(".profile-follow-button");
    const unfollowButton = document.querySelector(".profile-unfollow-button");

    if(followButton) {
        followButton.addEventListener("click", () => goToFollow(followButton.dataset.id));
    }

    if(unfollowButton) {
        unfollowButton.addEventListener("click", () => goToUnfollow(unfollowButton.dataset.id));
    }

    function goToFollow(id) {
        location.href = url + "profile/follow/" + id;
    }

    function goToUnfollow(id) {
        location.href = url + "profile/unfollow/" + id;
    }
</script>

<?php
    include("../app/views/footer.php");
?>