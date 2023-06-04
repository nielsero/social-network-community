<?php
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "community";
    $membros = $data["membros"];
    $comunidade = $data["comunidade"];
    $criador = $data["criador"];
    $title = $comunidade["comunidade_nome"];
    $comunidade_foto = $comunidade["comunidade_foto_url"];
    $conteudos = $data["conteudos"];
    $state = $data["state"];

    include("../app/views/header.php");

    // Set default if profile_picture is null
    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }

    if(!$comunidade_foto) {
        $comunidade_foto = $url."/assets/images/default_group_avatar.jpg";
    }

    if($membros) {
        $nr_membros = count($membros);
    } else {
        $nr_membros = 0;
    }
?>

<main class="community-show">
    <?php include("../app/views/nav.php") ?>

    <section class="community-show-section">
        <div class="community-show-posts">
            <h1 class="home-posts-title">Conteúdos</h1>

            <?php
                if(count($conteudos) == 0) {
                    echo "<p class='community-posts-empty-text'>Comunidade sem conteudo</p>";
                }

                else {
                    echo "<div class='community-posts'>";
                    foreach ($conteudos as $conteudo) {
                        $tipo = $conteudo["tipo"];
                        echo "<div class='community-post' data-tipo='".$tipo." data-id='".$conteudo["id"]."''>";
                        $publicador = $conteudo["publicador"];
                        if($tipo == "artigo") {
                            echo "<div class='community-post-type'><i class='bx bxs-message-alt-detail'></i> Artigo publicado por <span class='home-post-community'>".$publicador["usuario_nome"]."</span></div>";
                        } else if($tipo == "foto") {
                            echo "<div class='community-post-type'><i class='bx bxs-image'></i> Foto publicado por <span class='home-post-community'>".$publicador["usuario_nome"]."</span></div>";
                        } else if($tipo == "video") {
                            echo "<div class='community-post-type'><i class='bx bxs-video'></i> Video publicado por <span class='home-post-community'>".$publicador["usuario_nome"]."</span></div>";
                        }
                        echo "<h2 class='community-post-title'>".$conteudo["titulo"]."</h2>";
                        echo "<p class='community-post-description'>".$conteudo["descricao"]."</p>";
                        echo "<p class='community-post-date-publicated'>".$conteudo["data_publicacao"]."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>

        <div class="community-show-info" data-community='<?= $comunidade["comunidade_id"] ?>'>
            <h1 class='community-show-name'><?= $comunidade["comunidade_nome"] ?></h1>
            <div class='community-show-image-container'><img class='community-show-image' src='<?= $comunidade_foto ?>'></div>
            <p class='community-show-description'><?= $comunidade["comunidade_descricao"] ?></p>
            <p class='community-show-members'>Membros: <?= $nr_membros ?></p>
            <p class='community-show-creation-date'>Criado em <?= $comunidade["data_criacao"] ?></p>
            <p class='community-show-creator'>Por <?= $criador["usuario_nome"] ?></p>

            <?php
                if($state == "member") {
                    echo "<button class='community-show-content-button'>Publicar conteudo</button>";
                    echo "<button class='community-show-leave-button'>Sair da comunidade</button>";
                } else {
                    echo "<button class='community-show-enter-button'>Entrar na comunidade</button>";
                }
            ?>

        </div>
    </section>
</main>

<script>
    const communityShowInfo = document.querySelector(".community-show-info");
    const communityId = communityShowInfo.dataset.community;
    const createContentButton = document.querySelector(".community-show-content-button");
    const leaveButton = document.querySelector(".community-show-leave-button");
    const enterButton = document.querySelector(".community-show-enter-button");

    if(createContentButton) {
        createContentButton.addEventListener("click", () => { createContent(communityId); });
    }

    if(leaveButton) {
        leaveButton.addEventListener("click", () => { leaveCommunity(communityId); });
    }

    if(enterButton) {
        enterButton.addEventListener("click", () => { enterCommunity(communityId); });
    }

    function createContent(communityId) {
        location.href = url + "content/create/" + communityId;
    }

    function leaveCommunity(communityId) {
        location.href = url + "community/leave/" + communityId;
    }

    function enterCommunity(communityId) {
        location.href = url + "community/enter/" + communityId;
    }
</script>

<?php
    include("../app/views/footer.php");
?>