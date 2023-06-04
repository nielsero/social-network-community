<?php
    $title = "Login";
    $state = $data["state"];
    include("../app/views/header.php");
?>

<main class="login">
    <section class="login-image-section">
        <img class="login-image" src="<?= $url."assets/images/login.jpg" ?>" loading="lazy">
    </section>

    <section class="login-form-section">
        <form class="login-form" action="<?= $url."login/submit"?>" method="POST">
            <h1 class="login-title">Login</h1>
            <input class="login-email" type="email" name="email" placeholder="Email" required>
            <input class="login-password" type="password" name="password" placeholder="Senha" required>
            <button class="login-button" type="submit" name="login">Login</button>
            <p class="login-info">Não tens conta? <a href="<?= $url."register" ?>">Registre-se</a></p>

            <?php
                if($state == "registered") {
                    echo "
                        <div class='login-registered'>
                            <p>Conta criada</p>
                        </div>
                    ";
                }

                else if($state == "error") {
                    echo "
                        <div class='login-error'>
                            <p>Credenciais invalidas. Tente novamente</p>
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