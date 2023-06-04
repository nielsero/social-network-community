<?php
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $active = "community";
    $comunidade = $data["comunidade"];
    $title = "Publicar conteudo";
    $state = $data["state"];

    include("../app/views/header.php");

    // Set default if profile_picture is null
    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="content-create">
    <?php include("../app/views/nav.php") ?>

    <section class="content-create-section">
        <form class="content-create-form" action="<?= $url."content/publish" ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= $comunidade["comunidade_id"] ?>" name="comunidade_id">
            <h1 class="content-create-form-title">Publicar conteudo</h1>
            <select class="content-create-select" name="tipo">
                <option value="artigo" selected>Artigo</option>
                <option value="foto">Foto</option>
                <option value="video">Video</option>
            </select>  
            <input class="content-create-title" type="text" placeholder="Titulo" name="titulo">
            <textarea class="content-create-description" placeholder="Descricao" name="descricao"></textarea>
            <textarea class="content-create-text" placeholder="Texto" name="texto"></textarea>
            <div class="content-create-foto-upload-container invisible">
                <label class="content-create-upload-foto-title">Upload foto</label>
                <input class="content-create-upload-foto" type="file" name="foto">
            </div>
            <div class="content-create-foto-upload-video-container invisible">
                <label class="content-create-upload-video-title">Upload video</label>
                <input class="content-create-upload-video" type="file" name="video">
            </div>
            <button class="content-create-publish-button" type="submit" name="publicar">Publicar</button>

            <?php
                if($state == "error") {
                    echo "
                        <div class='content-create-error'>
                            <p>Falha ao publicar o conteudo</p>
                        </div>
                    ";
                }

                else if($state == "created") {
                    echo "
                        <div class='content-create-sucessful'>
                            <p>Conteudo publicado com sucesso</p>
                        </div>
                    ";
                }
            ?>
        </form>
    </section>
</main>

<script>
    const select = document.querySelector(".content-create-select");
    const textArea = document.querySelector(".content-create-text");
    const fotoUpload = document.querySelector(".content-create-foto-upload-container");
    const videoUpload = document.querySelector(".content-create-foto-upload-video-container");

    select.addEventListener("change", handleSelectChange);

    function handleSelectChange() {
        if(select.value == "artigo") {
            textArea.classList.remove("invisible");
            fotoUpload.classList.add("invisible");
            videoUpload.classList.add("invisible");
        } else if(select.value == "foto") {
            textArea.classList.add("invisible");
            fotoUpload.classList.remove("invisible");
            videoUpload.classList.add("invisible");
        } else {
            textArea.classList.add("invisible");
            fotoUpload.classList.add("invisible");
            videoUpload.classList.remove("invisible");
        }
    }
</script>

<?php
    include("../app/views/footer.php");
?>