<?php
    $title = "Seguidores";
    $usuario = $data["usuario"];
    $profile_picture = $usuario["usuario_foto_url"];
    $seguidores = $data["seguidores"];
    $seguidos = $data["seguidos"];
    $active = "follow";

    include("../app/views/header.php");

    // Set default if profile_picture is null
    if(!$profile_picture) {
        $profile_picture = $url."/assets/images/default_avatar.jpg";
    }
?>

<main class="follow">
    <?php include("../app/views/nav.php") ?>

    <section class="follow-section">
        <div class="follow-followers">
            <h1 class="followers-title">Seguidores</h1>

            <?php
                if(count($seguidores) == 0) {
                    echo "<p class='followers-empty'>Nao tens seguidores</p>";
                }
                else {
                    echo "<div class='followers'>";
                    foreach($seguidores as $seguidor) {
                        $foto = $url."/assets/images/default_avatar.jpg";
                        if($seguidor["usuario_foto_url"]) {
                            $foto = $seguidor["usuario_foto_url"];
                        }
                        echo "<div class='follower' data-id='".$seguidor["usuario_id"]."'>";
                        echo "<div class='follower-image-container'><img class='follower-image' src='".$foto."'></div>";
                        echo "<p class='follower-name'>".$seguidor["usuario_nome"]."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>

            
        </div>

        <div class="follow-following">
            <h1 class="following-title">Seguindo</h1>

            <?php
                if(count($seguidos) == 0) {
                    echo "<p class='following-empty'>Nao segues a ninguem</p>";
                }
                else {
                    echo "<div class='followings'>";
                    foreach($seguidos as $seguido) {
                        $foto = $url."/assets/images/default_avatar.jpg";
                        if($seguido["usuario_foto_url"]) {
                            $foto = $seguido["usuario_foto_url"];
                        }
                        echo "<div class='following' data-id='".$seguido["usuario_id"]."'>";
                        echo "<div class='following-image-container'><img class='following-image' src='".$foto."'></div>";
                        echo "<p class='following-name'>".$seguido["usuario_nome"]."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </section>
</main>

<script>
    const followers = document.querySelectorAll(".follower");
    const followings = document.querySelectorAll(".following");

    followers.forEach((follower) => {
        follower.addEventListener("click", () => goToProfile(follower.dataset.id));
    });

    followings.forEach((following) => {
        following.addEventListener("click", () => goToProfile(following.dataset.id));
    });

    function goToProfile(id) {
        location.href = url + "/profile/index/" + id;
    }
</script>

<?php
    include("../app/views/footer.php");
?>