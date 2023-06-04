<?php
    $title = "Home";
    $usuario = $data["usuario"];
    $comunidades = $data["comunidades"];
    $conteudos = $data["conteudos"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "home";

    include("../app/views/header.php");

    // Set default if profile_picture is null
    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="home">
    <?php include("../app/views/nav.php") ?>

    <section class="home-section">
        <div class="home-communities-section">
            <h1 class="home-comunities-title">Suas communidades</h1>
            <?php
                if(!$comunidades) {
                    echo "<p class='home-comunities-empty-text'>Não fazes parte de nenhuma comunidade. <a href='#'>Ver comunidades</a></p>";
                }

                else {
                    echo "<div class='home-communities'>";
                    foreach ($comunidades as $comunidade) {
                        $comunidade_foto = $url."assets/images/default_group_avatar.jpg";
                        if($comunidade["comunidade_foto_url"]){
                            $comunidade_foto = $comunidade["comunidade_foto_url"];
                        }
                        echo "
                            <div class='home-community' data-id='".$comunidade["comunidade_id"]."' data-foto='".$comunidade_foto."'>
                                <h2 class='home-community-name'>".$comunidade["comunidade_nome"]."</h2>
                                <p class='home-community-description'>".$comunidade["comunidade_descricao"]."</p>
                            </div>
                        ";
                    }
                    echo "</div>";
                }
            ?>
        </div>

        <div class="home-posts-section">
            <h1 class="home-posts-title">Seus conteúdos</h1>

            <?php
                if(count($conteudos) == 0) {
                    echo "<p class='home-posts-empty-text'>Ainda não publicaste nenhum conteúdo. Os conteúdos são publicados nas comunidades.</p>";
                }

                else {
                    echo "<div class='home-posts'>";
                    foreach ($conteudos as $conteudo) {
                        $tipo = $conteudo["tipo"];
                        echo "<div class='home-post' data-tipo='".$tipo." data-id='".$conteudo["id"]."''>";
                        $comunidade = $conteudo["comunidade"];
                        if($tipo == "artigo") {
                            echo "<div class='home-post-type'><i class='bx bxs-message-alt-detail'></i> Artigo em <span class='home-post-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        } else if($tipo == "foto") {
                            echo "<div class='home-post-type'><i class='bx bxs-image'></i> Foto em <span class='home-post-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        } else if($tipo == "video") {
                            echo "<div class='home-post-type'><i class='bx bxs-video'></i> Video em <span class='home-post-community'>".$comunidade["comunidade_nome"]."</span></div>";
                        }
                        echo "<h2 class='home-post-title'>".$conteudo["titulo"]."</h2>";
                        echo "<p class='home-post-description'>".$conteudo["descricao"]."</p>";
                        echo "<p class='home-post-date-publicated'>".$conteudo["data_publicacao"]."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </section>
</main>

<script>
    const homeCommunities = document.querySelectorAll(".home-community");

    homeCommunities.forEach((community) => {
        const foto = community.dataset.foto;
        if(foto != "") {
            community.style.background = `linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)), url(${foto})`;
            community.style.backgroundSize = "cover";
            community.style.backgroundPosition = "center";
        }
        
        // also add event listeners
        community.addEventListener("click", () => { handleCommunityClick(community.dataset.id); });
    });

    function handleCommunityClick(id) {
        // url was declared in nav.js
        location.href = url + "community/show/" + id;
    }
</script>

<?php
    include("../app/views/footer.php");
?>