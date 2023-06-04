<?php
    $title = "Comunidades";
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "community";

    $comunidades = $data["comunidades"];

    include("../app/views/header.php");

    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="community-main">
    <?php include("../app/views/nav.php") ?>

    <section class="community-section">
        <h1 class="community-title">Comunidades <button class="community-create-button" onclick="createCommunity();">Criar</button></h1>
        
        <?php
            if(!$comunidades) {
                echo "<p class='community-empty-text'>Ainda não existem comunidades</p>";
            }

            else {
                echo "<div class='communities'>";
                foreach ($comunidades as $comunidade) {
                    $comunidade_foto = $url."assets/images/default_group_avatar.jpg";;
                    if($comunidade["comunidade_foto_url"]){
                        $comunidade_foto = $comunidade["comunidade_foto_url"];
                    }
                    echo "
                        <div class='community' data-id='".$comunidade["comunidade_id"]."' data-foto='".$comunidade_foto."'>
                            <h2 class='community-name'>".$comunidade["comunidade_nome"]."</h2>
                            <p class='community-description'>".$comunidade["comunidade_descricao"]."</p>
                        </div>
                    ";
                }
                echo "</div>";
            }
        ?>
    </section>
</main>

<script>
    const communities = document.querySelectorAll(".community");

    communities.forEach((community) => {
        const foto = community.dataset.foto;
        if(foto != "") {
            community.style.background = `linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)), url(${foto})`;
            community.style.backgroundSize = "cover";
            community.style.backgroundPosition = "center";
        }

        community.addEventListener("click", () => { handleCommunityClick(community.dataset.id); });
    });

    function handleCommunityClick(id) {
        location.href = url + "community/show/" + id;
    }

    function createCommunity() {
        location.href = url + "community/create";
    }
</script>

<?php
    include("../app/views/footer.php");
?>