<?php
    $title = "Criar comunidade";
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "community";
    $state = $data["state"];

    include("../app/views/header.php");

    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="community-create">
    <?php include("../app/views/nav.php") ?>

    <section class="community-create-section">
        <form class="community-create-form" method="POST">
            <h1 class="community-create-title">Criar comunidade</h1>
            <input class="community-create-name" type="text" placeholder="Nome" name="nome">
            <textarea class="community-create-description" placeholder="Descricao" name="descricao"></textarea>
            <button class="community-create-submit-button" type="submit" name="create">Criar</button>

            <?php
                if($state == "error") {
                    echo "
                        <div class='community-create-error'>
                            <p>Falha ao criar a comunidade</p>
                        </div>
                    ";
                }

                else if($state == "created") {
                    echo "
                        <div class='community-create-sucessful'>
                            <p>Comunidade criada com sucesso</p>
                        </div>
                    ";
                }
            ?>
        </form>
    </section>
</main>

<?php
    include("../app/views/footer.php");
?>